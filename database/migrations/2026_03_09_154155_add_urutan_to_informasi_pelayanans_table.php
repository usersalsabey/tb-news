<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::table('informasi_pelayanans', function (Blueprint $table) {
        $table->integer('urutan')->default(0)->after('is_active');
    });
}
public function down(): void {
    Schema::table('informasi_pelayanans', function (Blueprint $table) {
        $table->dropColumn('urutan');
    });
}
};
