<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_booking_docs', function (Blueprint $table) {
            $table->id();
            $table->string('doc')->nullable();
            $table->unsignedBigInteger('request_booking_id')->nullable();
            $table->foreign('request_booking_id')->references('id')->on('request_booking_docs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_booking_docs');
    }
};
