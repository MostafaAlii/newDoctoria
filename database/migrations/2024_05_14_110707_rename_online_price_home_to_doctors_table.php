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
        Schema::table('doctors', function (Blueprint $table) {
            $table->renameColumn('online_price', 'service_price_online');
            $table->renameColumn('offline_price','service_price_home');
            $table->dropColumn(['service_price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->renameColumn('service_price_online', 'online_price');
            $table->renameColumn('service_price_home', 'offline_price');
        });
    }
};
