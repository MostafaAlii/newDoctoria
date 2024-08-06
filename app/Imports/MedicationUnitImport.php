<?php

namespace App\Imports;

use App\Models\MedicationUnit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MedicationUnitImport implements  ToModel, WithHeadingRow
{
    public function __construct()
    {
    }
    public function model(array $row)
    {


                $name = [];
                $name['en'] = $row['name_en'];
                $name['ar'] = $row['name_ar'];

                MedicationUnit::create([
                    'unit' => $name,
                ]);

        return null; // Return null to skip adding a new model to the collection
    }
}
