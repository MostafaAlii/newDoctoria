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
        Schema::create('sc_services', function (Blueprint $table) {
            $table->id();
            $table->string('name',500)->nullable();
            $table->text('description')->nullable();
            $table->double('price')->nullable();
            $table->string('sessions_non')->nullable();
            $table->string('have_request')->nullable();
            $table->unsignedBigInteger('sc_type_id')->nullable();
            $table->foreign('sc_type_id')->references('id')->on('sc_types')->onDelete('cascade');
            $table->unsignedBigInteger('experience_id')->nullable();
            $table->foreign('experience_id')->references('id')->on('experiences')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sc_services');
    }
};
