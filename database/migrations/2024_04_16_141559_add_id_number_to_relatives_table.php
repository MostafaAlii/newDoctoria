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
        Schema::table('relatives', function (Blueprint $table) {
            //
            $table->dropColumn('age');
            $table->string('id_number')->nullable()->after('id');
            $table->string('address',500)->nullable()->after('id');
            $table->date('birth_date')->nullable()->after('id');
            $table->unsignedBigInteger('nationality_id')->nullable()->after('id');
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');

            $table->unsignedBigInteger('country_id')->nullable()->after('id');
            $table->foreign('country_id')->references('id')->on('nationalities')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relatives', function (Blueprint $table) {
            //
        });
    }
};
