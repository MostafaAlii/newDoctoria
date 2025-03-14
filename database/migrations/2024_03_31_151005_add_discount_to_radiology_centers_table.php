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
        Schema::table('radiology_centers', function (Blueprint $table) {
            //
            $table->double('discount')->default(0)->after('id');
            $table->double('cashback')->default(0)->after('id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('radiology_centers', function (Blueprint $table) {
            //
        });
    }
};
