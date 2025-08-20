<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('user_profiles', 'status')) {
                $table->string('status')->nullable()->after('jenis_kelamin');
            }
            if (! Schema::hasColumn('user_profiles', 'tgl_lahir')) {
                $table->date('tgl_lahir')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('user_profiles', 'tgl_lahir')) $table->dropColumn('tgl_lahir');
            if (Schema::hasColumn('user_profiles', 'status'))    $table->dropColumn('status');
        });
    }
};
