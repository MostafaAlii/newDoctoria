<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DiagnosesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('seeds/data/test.csv');

        // Open the CSV file
        $file = fopen($filePath, 'r');
        
        // Read the header row
        $header = fgetcsv($file);

        // Loop through the remaining rows
        while ($row = fgetcsv($file)) {
            $data = array_combine($header, $row);
            $diagnosis = json_encode([
                'ar' => '',
                'en' => $data['SHORT DESCRIPTION (VALID ICD-10 FY2024)'],
            ]);

            // Insert the data into the diagnoses table
            DB::table('diagnoses')->insert([
                'diagnosis' => $diagnosis,
            ]);
        }

        // Close the CSV file
        fclose($file);
    }
}
