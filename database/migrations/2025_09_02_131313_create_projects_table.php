<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('projects', function (Blueprint $t) {
      $t->id();
      $t->foreignId('user_id')->constrained()->cascadeOnDelete(); // pembuat (student)
      $t->string('title');              // nama karya/produk
      $t->text('description');         // deskripsi singkat
      $t->string('image_path')->nullable(); // cover (disimpan di storage/public)
      $t->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('projects');
  }
};
