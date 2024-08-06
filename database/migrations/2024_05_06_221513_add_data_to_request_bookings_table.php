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
            $table->dropColumn(['average_price']);
            $table->double('from_price')->nullable();
            $table->double('to_price')->nullable();
            $table->date('day')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->unsignedBigInteger('specialization_id')->nullable()->after('id');
            $table->foreign('specialization_id')->references('id')->on('specializations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
