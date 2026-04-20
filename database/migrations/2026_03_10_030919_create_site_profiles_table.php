<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi')->default('Polres Gunungkidul');
            $table->string('kapolres')->nullable();
            $table->string('foto_kapolres')->nullable();
            $table->text('sambutan')->nullable();
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();
            $table->longText('sejarah')->nullable();
            $table->string('struktur_organisasi')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('hotline')->nullable();
            $table->string('hours')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_profiles');
    }
};