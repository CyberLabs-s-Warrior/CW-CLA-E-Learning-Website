<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // kolom baru agar sejalan referensi
            $table->text('alamat')->nullable()->after('phone_number');
            $table->string('telepon', 50)->nullable()->after('alamat');
            $table->text('link_maps')->nullable()->after('telepon'); // iframe gmaps
            $table->string('url_email')->nullable()->after('link_maps');
            $table->string('url_telepon')->nullable()->after('url_email');
            $table->string('url_alamat')->nullable()->after('url_telepon');
            $table->decimal('latitude', 11, 8)->nullable()->after('url_alamat');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });

        // migrasi nilai lama → kolom baru (aman kalau kolom lama kosong)
        DB::table('contacts')->update([
            'alamat'    => DB::raw('COALESCE(alamat, location_label)'),
            'telepon'   => DB::raw('COALESCE(telepon, phone_number)'),
            'link_maps' => DB::raw('COALESCE(link_maps, location_url)'),
        ]);
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'alamat','telepon','link_maps',
                'url_email','url_telepon','url_alamat',
                'latitude','longitude'
            ]);
        });
    }
};
