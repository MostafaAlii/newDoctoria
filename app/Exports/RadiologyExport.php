<?php

namespace App\Exports;

use App\Models\Radiology;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RadiologyExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
    }

    public function collection()
    {
        // Fetch users data based on the received $roomId
        $rows =Radiology::select('price','radiology_center_id')->get();
        return $rows;
    }

    public function headings(): array
    {
        // Define column headers
        return [

            'price',
            'radiology_center_id',
            'name_en',
            'name_ar',
            // Add more column names as needed
        ];
    }
}
