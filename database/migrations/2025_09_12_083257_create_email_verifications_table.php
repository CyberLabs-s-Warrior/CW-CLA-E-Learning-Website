<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('email_verifications', function (Blueprint $t) {
            $t->id();
            $t->string('name', 100);
            $t->string('username', 30)->index();
            $t->string('email')->index();
            $t->string('phone', 32)->nullable();
            $t->string('password_hash'); // password sudah di-hash
            $t->string('token', 128)->unique(); // simpan hash token (SHA-256)
            $t->timestamp('expires_at')->index(); // masa berlaku link
            $t->timestamps();

            // cegah duplikasi pending
            $t->unique(['email']);
            $t->unique(['username']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('email_verifications');
    }
};
