<?php

namespace App\Filament\Pages\Auth;

use App\Mail\LoginOtpMail;
use App\Models\LoginOtp;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Login extends BaseLogin
{
    public bool $showOtpForm = false;

    public function mount(): void
{
    dd('mount jalan');
    parent::mount();
    $this->showOtpForm = Session::has('otp_user_id');
}
    public function form(Form $form): Form
    {
        if ($this->showOtpForm) {
            return $form->schema([
                TextInput::make('otp')
                    ->label('Kode OTP')
                    ->placeholder('Masukkan 6 digit kode OTP')
                    ->required()
                    ->maxLength(6),
            ]);
        }

        return parent::form($form);
    }

    public function authenticate(): ?LoginResponse
    {
        dd('custom login jalan'); // ← debug sementara

        if ($this->showOtpForm) {
            return $this->verifyOtp();
        }

        $data = $this->form->getState();
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            $this->addError('data.email', 'Email atau password salah.');
            return null;
        }

        LoginOtp::where('user_id', $user->id)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        LoginOtp::create([
            'user_id'    => $user->id,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new LoginOtpMail($user, $otp));

        Session::put('otp_user_id', $user->id);

        $this->showOtpForm = true;

        return null;
    }

    protected function verifyOtp(): ?LoginResponse
    {
        $data   = $this->form->getState();
        $userId = Session::get('otp_user_id');

        $record = LoginOtp::where('user_id', $userId)
            ->where('otp', $data['otp'])
            ->first();

        if (!$record) {
            $this->addError('data.otp', 'Kode OTP salah.');
            return null;
        }

        if (now()->isAfter($record->expires_at)) {
            $this->addError('data.otp', 'Kode OTP sudah kadaluarsa.');
            Session::forget('otp_user_id');
            $this->showOtpForm = false;
            return null;
        }

        auth()->loginUsingId($userId);
        $record->delete();
        Session::forget('otp_user_id');

        return app(LoginResponse::class);
    }
}