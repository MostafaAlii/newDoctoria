<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('main_otp_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->unique()->nullable();
            $table->boolean('status', true)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('main_otp_providers');
    }
};
