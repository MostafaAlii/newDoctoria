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
        Schema::table('patients', function (Blueprint $table) {
            //
            $table->double('age')->nullable()->after('id');
            $table->enum('marital_status',['single','married'])->nullable()->after('id');
            $table->string('occupation')->nullable()->after('id');
            $table->string('residence')->nullable()->after('id');
            $table->boolean('is_smoking')->default(0)->after('id');
            $table->boolean('is_alcoholic')->default(0)->after('id');
            $table->string('athlete')->nullable()->after('id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            //
        });
    }
};
