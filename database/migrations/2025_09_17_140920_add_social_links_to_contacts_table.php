<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('social_facebook', 255)->nullable()->after('url_alamat');
            $table->string('social_instagram', 255)->nullable()->after('social_facebook');
            $table->string('social_tiktok', 255)->nullable()->after('social_instagram');
            $table->string('social_x', 255)->nullable()->after('social_tiktok'); // X (Twitter)
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['social_facebook','social_instagram','social_tiktok','social_x']);
        });
    }
};
