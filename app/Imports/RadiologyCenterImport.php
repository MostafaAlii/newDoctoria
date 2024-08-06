<?php

namespace App\Imports;

use App\Models\RadiologyCenter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RadiologyCenterImport implements  ToModel, WithHeadingRow
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
                RadiologyCenter::create([
                    'name' => $name,
                    'desc' => $desc,
                    'location'=>$row['location'],
                    'toTime'=>$row['work_to'],
                    'fromTime'=>$row['work_from'],
                    'discount'=>$discount,
                    'cashback'=>$cashback,
                ]);



        return null; // Return null to skip adding a new model to the collection
    }
}
