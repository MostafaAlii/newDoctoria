<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('seeds/data/Medicines.csv');

        // Open the CSV file
        if (($file = fopen($filePath, 'r')) !== false) {
            // Loop through each row
            while (($row = fgetcsv($file)) !== false) {
                // Since there's only one column in the CSV, we access the first element
                $unitValue = $row[0];
                $unit = json_encode([
                    'ar' => '',
                    'en' => $unitValue,
                ]);

                // Insert the data into the table
                DB::table('medication_units')->insert([
                    'unit' => $unit,
                ]);
            }

            // Close the CSV file
            fclose($file);
        }
    }
}
