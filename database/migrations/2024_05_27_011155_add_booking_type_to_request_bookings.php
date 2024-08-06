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
        Schema::table('request_bookings', function (Blueprint $table) {
            $table->enum('booking_type', ['insurance','individual', 'package'])->default('individual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_bookings', function (Blueprint $table) {
            //
        });
    }
};
