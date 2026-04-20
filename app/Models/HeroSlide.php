<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = ['halaman', 'foto', 'caption', 'urutan', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    /**
     * Ambil slides aktif untuk halaman tertentu, urut by urutan ASC
     */
    public static function getSlides(string $halaman)
    {
        return static::where('halaman', $halaman)
            ->where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->get();
    }
}