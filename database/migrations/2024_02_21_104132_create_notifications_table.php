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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title',500)->nullable();
            $table->text('body')->nullable();
            $table->enum('user_type',['patient','doctor'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('type',['booking','accept'])->nullable();
            $table->date('date')->nullable();
            $table->boolean('is_read')->default(0);
            $table->unsignedBigInteger('foreign_id')->nullable();
            $table->unsignedBigInteger('main_service_id')->nullable();
            $table->foreign('main_service_id')->references('id')->on('main_services');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
