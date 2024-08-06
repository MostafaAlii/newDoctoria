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
        Schema::table('settings', function (Blueprint $table) {
            $table->text('about')->nullable();
            $table->text('facebook')->nullable();
            $table->text('facebook_icon')->nullable();
            $table->text('website')->nullable();
            $table->text('website_icon')->nullable();
            $table->text('email')->nullable();
            $table->text('email_icon')->nullable();
            $table->text('phone')->nullable();
            $table->text('phone_icon')->nullable();
            $table->text('google')->nullable();
            $table->text('google_icon')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('about');
            $table->dropColumn('facebook');
            $table->dropColumn('facebook_icon');
            $table->dropColumn('website');
            $table->dropColumn('website_icon');
            $table->dropColumn('email');
            $table->dropColumn('email_icon');
            $table->dropColumn('phone');
            $table->dropColumn('phone_icon');
            $table->dropColumn('google');
            $table->dropColumn('google_icon');
        });
    }
};
