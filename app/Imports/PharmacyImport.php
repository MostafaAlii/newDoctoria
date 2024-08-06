<?php

namespace App\Imports;

use App\Models\Pharmacy;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PharmacyImport implements  ToModel, WithHeadingRow
{
    public function __construct()
    {
    }
    public function model(array $row)
    {


                $name = [];
                $name['en'] = $row['name_en'];
                $name['ar'] = $row['name_ar'];
                $desc = [];
                $desc['en'] = $row['desc_en'];
                $desc['ar'] = $row['desc_ar'];

                $discount=$cashback=0;

                if ($row['discount']!=null)
                    $discount=$row['discount'];
                if ($row['cashback']!=null)
                    $cashback=$row['cashback'];
                Pharmacy::create([
                    'name' => $name,
                    'desc' => $desc,
                    'location'=>$row['location'],
                    'work_to'=>$row['work_to'],
                    'work_from'=>$row['work_from'],
                    'discount'=>$discount,
                    'cashback'=>$cashback,
                ]);




        return null; // Return null to skip adding a new model to the collection
    }
}
