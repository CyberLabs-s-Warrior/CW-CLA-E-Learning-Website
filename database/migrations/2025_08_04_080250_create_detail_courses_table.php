<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('media')->nullable();
            $table->json('modules');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_courses');
    }
};
