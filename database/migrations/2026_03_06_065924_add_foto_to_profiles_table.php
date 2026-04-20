<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
        $table->string('foto_kapolres')->nullable()->after('kapolres');
        $table->string('struktur_organisasi')->nullable()->after('foto_kapolres');
        $table->dropColumn('statistik'); // hapus kolom statistik
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
        $table->dropColumn(['foto_kapolres', 'struktur_organisasi']);
        $table->json('statistik')->nullable();
    });
    }
};
