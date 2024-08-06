<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('request_bookings', function (Blueprint $table) {
            DB::statement("ALTER TABLE request_bookings MODIFY type ENUM('nursing','visit_doctor', 'physical_therapy') DEFAULT 'visit_doctor' ");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_bookings', function (Blueprint $table) {
            
            DB::statement("ALTER TABLE request_bookings MODIFY type ENUM('nursing','visit_doctor') DEFAULT 'visit_doctor' ");

        });
    }
};
