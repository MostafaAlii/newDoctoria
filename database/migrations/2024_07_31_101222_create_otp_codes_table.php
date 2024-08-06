<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('otp')->unique();
            $table->boolean('is_sent')->default(false);
            $table->enum('status', ['valid', 'invalid'])->default('invalid');
            $table->enum('type', ['email', 'whatsapp', 'sms'])->default('email');
            $table->string('phone_number')->nullable();
            $table->morphs('otpable');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('otp_codes');
    }
};
