<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\AdminCredentialsMail;
use App\Models\EmailVerification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate password random
        $this->rawPassword = Str::random(10);
        $data['password']   = Hash::make($this->rawPassword);
        $data['is_verified'] = false;
        return $data;
    }

    protected function afterCreate(): void
    {
        $user  = $this->record;
        $token = Str::random(64);

        // Simpan token verifikasi
        EmailVerification::create([
            'user_id'    => $user->id,
            'token'      => $token,
            'type'       => 'verify',
            'expires_at' => now()->addHours(24),
        ]);

        $verifyUrl = route('verify.email', ['token' => $token]);

        // Kirim email kredensial
        Mail::to($user->email)->send(
            new AdminCredentialsMail($user, $this->rawPassword, $verifyUrl)
        );
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}