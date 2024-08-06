<?php

namespace App\Exports;

use App\Models\RadiologyCenter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RadiologyCenterExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
    }

    public function collection()
    {
        // Fetch users data based on the received $roomId
        $radiology_center =RadiologyCenter::select('cashback','discount','fromTime','toTime','location')->get();
        return $radiology_center;
    }

    public function headings(): array
    {
        // Define column headers
        return [

            'cashback',
            'discount',
            'work_from',
            'work_to',
            'location',
            'name_en',
            'name_ar',
            'desc_en',
            'desc_ar',

            // Add more column names as needed
        ];
    }
}
