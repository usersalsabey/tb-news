<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('foto');   // URL YouTube / TikTok
            $table->string('video_path')->nullable()->after('video_url'); // Upload file langsung
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'video_path']);
        });
    }
};