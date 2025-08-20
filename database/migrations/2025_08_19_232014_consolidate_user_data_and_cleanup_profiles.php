<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Salin data nama & no_hp ke users bila kosong
        DB::statement("
            UPDATE users u
            JOIN user_profiles p ON p.user_id = u.id
            SET
                u.name  = COALESCE(u.name,  p.nama_lengkap),
                u.phone = COALESCE(u.phone, p.no_hp)
        ");

        // 2) Pindah foto dari users ke user_profiles bila profil.foto masih null
        if (Schema::hasColumn('users', 'foto')) {
            DB::statement("
                UPDATE user_profiles p
                JOIN users u ON p.user_id = u.id
                SET p.foto = COALESCE(p.foto, u.foto)
            ");
        }

        // 3) Drop kolom tidak dipakai di user_profiles (kecuali jenis_kelamin & foto)
        Schema::table('user_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('user_profiles', 'nama_lengkap')) $table->dropColumn('nama_lengkap');
            if (Schema::hasColumn('user_profiles', 'no_hp'))        $table->dropColumn('no_hp');
            if (Schema::hasColumn('user_profiles', 'alamat'))       $table->dropColumn('alamat');
            if (Schema::hasColumn('user_profiles', 'status'))       $table->dropColumn('status');
            if (Schema::hasColumn('user_profiles', 'tgl_lahir'))    $table->dropColumn('tgl_lahir');
        });

        // 4) Drop kolom foto dari users (foto tinggal di profil)
        if (Schema::hasColumn('users', 'foto')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }
    }

    public function down(): void
    {
        // Balikkan skema (tanpa balikin data yang sudah dipindahkan)
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('email_verified_at');
        });
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('nama_lengkap')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('status')->nullable();
            $table->date('tgl_lahir')->nullable();
        });
        // Data tidak di-rollback otomatis.
    }
};
