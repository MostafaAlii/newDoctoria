<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('zoom_video_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('booking_id')->index()->constrained()->cascadeOnDelete();
            $table->string('call_id')->nullable();
            $table->string('topic')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->integer('duration')->comment('minutes')->nullable();
            $table->string('password')->comment('call password')->nullable();
            $table->text('start_url')->comment('start call url')->nullable();
            $table->text('join_url')->comment('join call url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('zoom_video_calls');
    }
};
