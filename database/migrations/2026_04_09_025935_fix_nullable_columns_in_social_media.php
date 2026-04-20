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
    Schema::table('social_media', function (Blueprint $table) {
        $table->string('platform')->nullable()->default(null)->change();
        $table->string('icon')->nullable()->default(null)->change();
        $table->string('handle')->nullable()->default(null)->change();
    });
}

public function down(): void
{
    Schema::table('social_media', function (Blueprint $table) {
        $table->string('platform')->nullable(false)->change();
        $table->string('icon')->nullable(false)->change();
        $table->string('handle')->nullable(false)->change();
    });
}
};
