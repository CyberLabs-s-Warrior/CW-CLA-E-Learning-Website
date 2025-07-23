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
    Schema::table('users', function (Blueprint $table) {
        // Untuk Spatie nanti, kita tambahkan role_id nullable
        $table->foreignId('role_id')->nullable()->after('password');

        // Untuk admin saja (superadmin, instructor, dll)
        $table->boolean('is_superadmin')->default(false)->after('role_id');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role_id', 'is_superadmin']);
    });
}

};
