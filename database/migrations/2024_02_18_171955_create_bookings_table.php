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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_service_id')->nullable();
            $table->foreign('main_service_id')->references('id')->on('main_services');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->enum('type',['online','offline'])->nullable();
            $table->date('day')->nullable();
            $table->time('time')->nullable();
            $table->text('desc')->nullable();
            $table->double('price')->default(0);
            $table->enum('status',['pending','active','complete'])->default('pending');
            $table->unsignedBigInteger('request_id')->nullable();
            $table->string('request_type')->nullable();
            $table->enum('operation_type',['package','insurance','paid_online'])->nullable();
            $table->unsignedBigInteger('operation_id')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
