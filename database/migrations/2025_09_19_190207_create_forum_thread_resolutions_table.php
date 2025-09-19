<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('forum_thread_resolutions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('thread_id')->unique()->constrained('forum_threads')->cascadeOnDelete();
      $table->foreignId('post_id')->constrained('forum_posts')->cascadeOnDelete();
      $table->foreignId('marked_by')->constrained('users')->cascadeOnDelete();
      $table->timestamps();

      $table->index('marked_by');
    });
  }
  public function down(): void {
    Schema::dropIfExists('forum_thread_resolutions');
  }
};
