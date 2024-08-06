<?php

namespace App\Imports;

use App\Models\Radiology;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RadiologyImport implements ToModel, WithHeadingRow
{
    public function __construct()
    {
    }

    public function model(array $row)
    {


                if ($row['radiology_center_id']) {

                    $radiology=Radiology::find($row['radiology_center_id']);

                    if ($radiology) {
                        $name = [];
                        $name['en'] = $row['name_en'];
                        $name['ar'] = $row['name_ar'];


                        Radiology::create([
                            'name' => $name,
                            'price' => $row['price'],
                            'radiology_center_id' => $row['radiology_center_id'],
                        ]);

                    }

                }




        return null; // Return null to skip adding a new model to the collection
    }
}
