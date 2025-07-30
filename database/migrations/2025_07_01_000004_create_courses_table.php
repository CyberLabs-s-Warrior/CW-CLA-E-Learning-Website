<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_category_id')->constrained()->onDelete('cascade');
        $table->foreignId('course_level_id')->constrained()->onDelete('cascade');
        $table->foreignId('course_price_range_id')->nullable()->constrained()->onDelete('set null');
        $table->string('name');
        $table->decimal('price', 10, 2);
        $table->string('img')->nullable();
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
