<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('social_media', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('icon')->nullable();
        $table->string('handle')->nullable();
        $table->string('url');
        $table->boolean('is_active')->default(true);
        $table->integer('urutan')->default(1);
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};