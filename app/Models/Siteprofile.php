<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteProfile extends Model
{
    protected $fillable = [
    'nama_instansi', 'kapolres', 'foto_kapolres', 'sambutan',
    'visi', 'misi', 'sejarah', 'struktur_organisasi',
    'address', 'city', 'email', 'phone', 'hotline', 'hours',
    'whatsapp_number', // tambah ini
];

    protected $casts = [
        'misi' => 'array',
    ];

    /**
     * Ambil misi sebagai array (kompatibel dengan controller lama)
     */
    public function getMisiArrayAttribute(): array
    {
        return $this->misi ?? [];
    }
}