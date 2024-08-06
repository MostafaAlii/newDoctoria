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
        Schema::create('replying_booking_radiologies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->unsignedBigInteger('replying_booking_id')->nullable();
            $table->foreign('replying_booking_id')->references('id')->on('replying_bookings')->onDelete('cascade');
            $table->unsignedBigInteger('radiology_center_id')->nullable();
            $table->foreign('radiology_center_id')->references('id')->on('radiology_centers');
            $table->unsignedBigInteger('radiology_id')->nullable();
            $table->foreign('radiology_id')->references('id')->on('radiologies');
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replying_booking_radiologies');
    }
};
