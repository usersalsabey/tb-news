<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanWbs extends Model
{
    protected $table = 'laporan_wbs';

    protected $fillable = [
        'nomor_tiket',
        'nama_pelapor',
        'nik',
        'no_hp',
        'alamat',
        'kategori',
        'informasi',
        'dokumen_utama',
        'dokumen_tambahan_1',
        'dokumen_tambahan_2',
        'status',
        'catatan_admin',
    ];
}