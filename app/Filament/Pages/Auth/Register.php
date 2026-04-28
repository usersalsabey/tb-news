<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nama')
                ->required(),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique('users', 'email'),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->minLength(8)
                ->confirmed(),

            TextInput::make('password_confirmation')
                ->label('Konfirmasi Password')
                ->password()
                ->required(),
        ]);
    }
}