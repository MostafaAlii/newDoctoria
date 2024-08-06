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
        Schema::create('main_services', function (Blueprint $table) {
            $table->id();
            $table->string('name',500)->nullable();
            $table->string('slug',500)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        $sql = [
            [
                'id' => 1,
                'name' => json_encode(['en' => 'General Consultation', 'ar' => 'استشارة عامة']),
                'slug' => 'general-consultation',
                'created_at' => '2022-03-27 13:57:36',
                'updated_at' => '2022-03-27 13:57:36',
            ],
            [
                'id' => 2,
                'name' => json_encode(['en' => 'Specialized Consultation', 'ar' => 'استشارة متخصصة']),
                'slug' => 'specialized-consultation',
                'created_at' => '2022-03-27 13:57:36',
                'updated_at' => '2022-03-27 13:57:36',
            ],
            [
                'id' => 3,
                'name' => json_encode(['en' => 'Home Care', 'ar' => 'رعاية منزلية']),
                'slug' => 'home-care',
                'created_at' => '2022-03-27 13:57:36',
                'updated_at' => '2022-03-27 13:57:36',
            ],
            [
                'id' => 4,
                'name' => json_encode(['en' => 'Medical File', 'ar' => 'ملف طبي']),
                'slug' => 'medical-file',
                'created_at' => '2022-03-27 13:57:36',
                'updated_at' => '2022-03-27 13:57:36',
            ],
            [
                'id' => 5,
                'name' => json_encode(['en' => 'Medical Bag', 'ar' => 'حقيبة طبية']),
                'slug' => 'medical-bag',
                'created_at' => '2022-03-27 13:57:36',
                'updated_at' => '2022-03-27 13:57:36',
            ],
        ];
        \Illuminate\Support\Facades\DB::table('main_services')->insert($sql);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_services');
    }
};
