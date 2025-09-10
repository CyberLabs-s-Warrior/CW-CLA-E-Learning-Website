<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_detail_instructor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_detail_id')
                  ->constrained('course_details')
                  ->cascadeOnDelete();
            $table->foreignId('instructor_id')
                  ->constrained('instructor_profiles')
                  ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_detail_instructor');
    }
};

