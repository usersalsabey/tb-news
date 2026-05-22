<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_laporan_wbs_table.php
public function up()
{
    Schema::create('laporan_wbs', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_tiket')->unique();
        $table->string('nama_pelapor');
        $table->string('nik', 16);
        $table->string('no_hp');
        $table->text('alamat');
        $table->string('kategori');
        $table->text('informasi');
        $table->string('dokumen_utama');
        $table->string('dokumen_tambahan_1')->nullable();
        $table->string('dokumen_tambahan_2')->nullable();
        $table->enum('status', ['Diterima', 'Diproses', 'Selesai'])->default('Diterima');
        $table->text('catatan_admin')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_wbs');
    }
};
