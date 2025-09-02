<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            $table->string('module_name');
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->string('media')->nullable();

            $table->integer('order')->default(1);
            $table->unsignedInteger('duration')->nullable();
            $table->boolean('is_preview')->default(false);

            $table->timestamps();

            // Optional: pastikan slug unik per course
            $table->unique(['course_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
