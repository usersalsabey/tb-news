<?php

namespace App\Filament\Pages;

use App\Models\LoginOtp;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

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