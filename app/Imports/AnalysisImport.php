<?php

namespace App\Imports;

use App\Models\Analysis;
use App\Models\Laboratory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnalysisImport implements ToModel, WithHeadingRow
{
    public function __construct()
    {
    }

    public function model(array $row)
    {


                if ($row['laboratory_id']) {

                    $laboratory=Laboratory::find($row['laboratory_id']);

                    if ($laboratory) {
                        $name = [];
                        $name['en'] = $row['name_en'];
                        $name['ar'] = $row['name_ar'];


                        Analysis::create([
                            'name' => $name,
                            'price' => $row['price'],
                            'laboratory_id' => $row['laboratory_id'],
                        ]);

                    }

                }




        return null; // Return null to skip adding a new model to the collection
    }
}
