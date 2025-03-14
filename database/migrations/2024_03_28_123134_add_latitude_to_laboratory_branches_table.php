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
        Schema::table('laboratory_branches', function (Blueprint $table) {
            //
            $table->string('latitude')->nullable()->after('id');
            $table->string('longitude')->nullable()->after('id');
            $table->unsignedBigInteger('governorate_id')->nullable();
            $table->foreign('governorate_id')->references('id')->on('governorates');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laboratory_branches', function (Blueprint $table) {
            //
        });
    }
};
