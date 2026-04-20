<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        // Data instansi
        'nama_instansi',
        'kapolres',
        'foto_kapolres',
        'struktur_organisasi',
        'alamat',
        'visi',
        'misi',
        'sejarah',
        'sambutan',

        // Kolom footer
        'hotline',
        'maps_url',
        'copyright',
        'url_instagram',
        'url_facebook',
        'url_youtube',
        'url_tiktok',
    ];

    protected $casts = [
        'misi' => 'array',
    ];
}