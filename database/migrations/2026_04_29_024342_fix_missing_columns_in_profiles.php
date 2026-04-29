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
        if (!Schema::hasColumn('profiles', 'telepon')) {
            $table->string('telepon')->nullable();
        }
        if (!Schema::hasColumn('profiles', 'hotline')) {
            $table->string('hotline')->nullable()->default('110 (Darurat)');
        }
        if (!Schema::hasColumn('profiles', 'maps_url')) {
            $table->string('maps_url')->nullable();
        }
        if (!Schema::hasColumn('profiles', 'copyright')) {
            $table->string('copyright')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
        });
    }
};
