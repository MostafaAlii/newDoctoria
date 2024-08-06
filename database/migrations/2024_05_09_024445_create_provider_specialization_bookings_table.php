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
        Schema::create('provider_specialization_bookings', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('from_time')->nullable();
            $table->string('to_time')->nullable();
            $table->text('location')->nullable();
            $table->text('description')->nullable();
            $table->text('referral_code')->nullable();
            $table->enum('booking_type', ['insurance','individual'])->default('individual');
            $table->enum('status',['pending','active','complete'])->default('pending');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedBigInteger('laboratory_id')->nullable();
            $table->foreign('laboratory_id')->references('id')->on('laboratories')->onDelete('cascade');
            $table->unsignedBigInteger('pharmacy_id')->nullable();
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade');
            $table->unsignedBigInteger('radiology_center_id')->nullable();
            $table->foreign('radiology_center_id')->references('id')->on('radiology_centers')->onDelete('cascade');
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_specialization_bookings');
    }
};
