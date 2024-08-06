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

        Schema::table('replying_bookings', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
        });
        Schema::table('replying_booking_medicals', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
        });
        Schema::table('replying_booking_diagnoses', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
        });
        Schema::table('replying_booking_analyses', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
        });
        Schema::table('replying_booking_radiologies', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('replying_booking_analyses', function (Blueprint $table) {
            //
        });
    }
};
