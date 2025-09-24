<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique(); // dari Midtrans
            $table->integer('gross_amount');      // jumlah bayar
            $table->string('payment_type')->nullable(); // bank_transfer, gopay, dll
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'cancel'])->default('pending');
            $table->timestamp('transaction_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
