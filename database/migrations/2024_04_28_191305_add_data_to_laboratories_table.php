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
        Schema::table('laboratories', function (Blueprint $table) {
            $table->text('about_us')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('phone')->nullable();
            $table->text('website_link')->nullable();
            $table->integer('rating_value')->nullable();
            $table->integer('num_of_raters')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
    }
};
