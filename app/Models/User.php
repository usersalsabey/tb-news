<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // app/Models/User.php
protected $fillable = [
    'name',
    'email',
    'password',
    'role',           // ← tambah
    'is_verified',    // ← tambah
];

protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_verified'       => 'boolean', // ← tambah
    ];
}

// Hanya yang sudah verified bisa masuk Filament
public function canAccessPanel(Panel $panel): bool
{
    return $this->is_verified === true;
}

public function emailVerifications()
{
    return $this->hasMany(\App\Models\EmailVerification::class);
}
}