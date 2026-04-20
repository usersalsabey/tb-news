<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_pelayanans', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('kategori');
            $table->string('judul');
            $table->text('deskripsi');
            $table->json('fitur');
            $table->string('link_label')->nullable();
            $table->json('links')->nullable();
            $table->string('warna')->default('blue');
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_pelayanans');
    }
};