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
        Schema::create('sc_types', function (Blueprint $table) {
            $table->id();
            $table->string('name',500)->nullable();
            $table->string('color')->nullable();
            $table->text('details')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('have_experience')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('sc_category_id')->nullable();
            $table->foreign('sc_category_id')->references('id')->on('sc_categories')->onDelete('cascade');
            $table->unsignedBigInteger('main_service_id')->nullable();
            $table->foreign('main_service_id')->references('id')->on('main_services')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sc_types');
    }
};
