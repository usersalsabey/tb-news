<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_verification_to_users_table.php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('admin'); // superadmin, admin, operator
        $table->boolean('is_verified')->default(false);
        $table->timestamp('email_verified_at')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
