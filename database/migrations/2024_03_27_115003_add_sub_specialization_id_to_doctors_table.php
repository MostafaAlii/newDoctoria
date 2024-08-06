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
        Schema::table('doctors', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('governorate_id')->nullable()->after('id');
            $table->foreign('governorate_id')->references('id')->on('governorates');

            $table->unsignedBigInteger('city_id')->nullable()->after('id');
            $table->foreign('city_id')->references('id')->on('cities');


            $table->unsignedBigInteger('sub_specialization_id')->nullable()->after('id');
            $table->foreign('sub_specialization_id')->references('id')->on('specializations');

            $table->unsignedBigInteger('experience_id')->nullable()->after('id');
            $table->foreign('experience_id')->references('id')->on('experiences');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            //
        });
    }
};
