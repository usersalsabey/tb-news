<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Kelola Admin';
    protected static ?string $modelLabel = 'Admin';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Lengkap')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->unique(ignoreRecord: true)
                ->required(),

            Forms\Components\Select::make('role')
                ->label('Role')
                ->options([
                    'superadmin' => 'Super Admin',
                    'admin'      => 'Admin',
                    'operator'   => 'Operator',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\BadgeColumn::make('role')
                ->colors([
                    'danger'  => 'superadmin',
                    'warning' => 'admin',
                    'success' => 'operator',
                ]),
            Tables\Columns\IconColumn::make('is_verified')
                ->label('Terverifikasi')
                ->boolean(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Dibuat'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}