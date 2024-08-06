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
        Schema::table('agora_rooms', function (Blueprint $table) {
            //
            $table->enum('type',['audio','video'])->default('audio')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agora_rooms', function (Blueprint $table) {
            //
        });
    }
};
