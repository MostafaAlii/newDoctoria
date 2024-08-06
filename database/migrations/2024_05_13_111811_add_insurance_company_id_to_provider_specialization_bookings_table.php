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
        Schema::table('provider_specialization_bookings', function (Blueprint $table) {
            $table->enum('booking_type', ['insurance','individual', 'cash_on_delivery'])->default('cash_on_delivery')->change();
            $table->text('other_phone_num')->nullable();
            $table->unsignedBigInteger('insurance_company_id')->nullable();
            $table->foreign('insurance_company_id')->references('id')->on('insurance_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_specialization_bookings', function (Blueprint $table) {

        });
    }
};
