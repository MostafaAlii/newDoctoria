<?php

namespace App\Exports;

use App\Models\MedicationUnit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MedicationUnitExport implements FromCollection, WithHeadings
{

    public function __construct()
    {
    }

    public function collection()
    {
        // Fetch users data based on the received $roomId
        $rows =MedicationUnit::select('unit')->where('id','<',0)->get();
        return $rows;
    }

    public function headings(): array
    {
        // Define column headers
        return [
            'name_en',
            'name_ar',

            // Add more column names as needed
        ];
    }
}
