<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_add_display_order_to_abouts_table.php
public function up()
{
    Schema::table('abouts', function (Blueprint $table) {
        $table->integer('display_order')->nullable()->after('section');
    });
}
public function down()
{
    Schema::table('abouts', function (Blueprint $table) {
        $table->dropColumn('display_order');
    });
}

};
