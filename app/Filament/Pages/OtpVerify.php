<?php

namespace App\Filament\Pages;

use App\Mail\LoginOtpMail;
use App\Models\LoginOtp;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Mail;

class OtpVerify extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.otp-verify';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Verifikasi OTP';
    protected static ?string $slug = 'otp-verify';

    public ?array $data = [];

    public function mount(): void
    {
        if (!auth()->check()) {
            redirect()->route('filament.admin.auth.login')->send();
            return;
        }

        $user = auth()->user();

        LoginOtp::where('user_id', $user->id)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        LoginOtp::create([
            'user_id'    => $user->id,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new LoginOtpMail($user, $otp));

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('otp')
                ->label('Kode OTP')
                ->placeholder('Masukkan 6 digit kode OTP dari email')
                ->required()
                ->maxLength(6)
                ->numeric(),
        ])->statePath('data');
    }

    public function verify(): void
    {
        $data   = $this->form->getState();
        $userId = auth()->id();

        $record = LoginOtp::where('user_id', $userId)
            ->where('otp', $data['otp'])
            ->first();

        if (!$record) {
            Notification::make()->title('Kode OTP salah!')->danger()->send();
            return;
        }

        if (now()->isAfter($record->expires_at)) {
            Notification::make()->title('Kode OTP kadaluarsa!')->danger()->send();
            $record->delete();
            return;
        }

        $record->delete();
        session(['otp_verified' => true]);

        redirect()->to(filament()->getHomeUrl());
    }
}
