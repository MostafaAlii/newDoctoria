<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('provider_times', function (Blueprint $table) {
            DB::statement("ALTER TABLE provider_times MODIFY provider_type ENUM('doctor_branch','doctor', 'laboratory', 'radiology_center') NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_times', function (Blueprint $table) {
            $table->enum('provider_type',['doctor', 'laboratory', 'radiology_center'])->nullable()->change();
        });
    }
};
