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
        Schema::create('sc_service_addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sc_service_id')->nullable();
            $table->foreign('sc_service_id')->references('id')->on('sc_services')->onDelete('cascade');
            $table->unsignedBigInteger('sc_addon_id')->nullable();
            $table->foreign('sc_addon_id')->references('id')->on('sc_addons')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sc_service_addons');
    }
};
