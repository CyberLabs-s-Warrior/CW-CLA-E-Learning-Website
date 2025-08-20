<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // username untuk login/identitas publik; nullable dulu supaya migrate aman.
            $table->string('username')->nullable()->unique()->after('name');
            // phone (no hp); nullable, boleh unik kalau kamu ingin satu nomor satu akun.
            $table->string('phone')->nullable()->after('email'); // ->unique() kalau mau
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'phone']);
        });
    }
};
