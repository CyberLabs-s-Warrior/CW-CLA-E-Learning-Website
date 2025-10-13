<?php

// database/migrations/2025_09_28_000000_create_lesson_progress_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('lesson_progress', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
      $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
      $table->boolean('is_completed')->default(true); // fleksibel kalau nanti mau add in_progress
      $table->timestamp('completed_at')->nullable();
      $table->timestamps();

      $table->unique(['user_id','lesson_id']); // hindari duplikat
      $table->index(['user_id','course_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('lesson_progress');
  }
};
