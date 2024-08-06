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
            $table->string('phone')->nullable()->after('id');
            $table->string('mobile')->nullable()->after('id');
            $table->string('email')->nullable()->after('id');
            $table->string('whatsapp')->nullable()->after('id');
            $table->dropColumn('name');

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
