<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiPelayanan extends Model
{
    protected $fillable = [
        'slug',
        'kategori',
        'judul',
        'deskripsi',
        'fitur',
        'link_label',
        'links',
        'warna',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'fitur'     => 'array',
        'links'     => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}