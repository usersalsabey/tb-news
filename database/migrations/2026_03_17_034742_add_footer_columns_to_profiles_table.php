<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'hotline')) {
                $table->string('hotline')->nullable()->default('110 (Darurat)');
            }
            if (!Schema::hasColumn('profiles', 'maps_url')) {
                $table->string('maps_url')->nullable()->default('https://maps.app.goo.gl/Xv8tKdyoVjMf4DkRA');
            }
            if (!Schema::hasColumn('profiles', 'copyright')) {
                $table->string('copyright')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'url_instagram')) {
                $table->string('url_instagram')->nullable()->default('https://www.instagram.com/polres.gunungkidul/');
            }
            if (!Schema::hasColumn('profiles', 'url_facebook')) {
                $table->string('url_facebook')->nullable()->default('https://www.facebook.com/polresgunungkidul');
            }
            if (!Schema::hasColumn('profiles', 'url_youtube')) {
                $table->string('url_youtube')->nullable()->default('https://www.youtube.com/@polresgunungkidul');
            }
            if (!Schema::hasColumn('profiles', 'url_tiktok')) {
                $table->string('url_tiktok')->nullable()->default('https://www.tiktok.com/@polres.gunungkidul');
            }
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'hotline', 'maps_url', 'copyright',
                'url_instagram', 'url_facebook', 'url_youtube', 'url_tiktok',
            ]);
        });
    }
};