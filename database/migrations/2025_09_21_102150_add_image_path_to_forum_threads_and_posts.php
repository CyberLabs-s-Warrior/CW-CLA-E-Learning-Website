<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            if (!Schema::hasColumn('forum_threads', 'image_path')) {
                $table->string('image_path')->nullable()->after('body');
            }
        });

        Schema::table('forum_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('forum_posts', 'image_path')) {
                $table->string('image_path')->nullable()->after('body');
            }
        });
    }

    public function down(): void
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            if (Schema::hasColumn('forum_posts', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });

        Schema::table('forum_threads', function (Blueprint $table) {
            if (Schema::hasColumn('forum_threads', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });
    }
};
