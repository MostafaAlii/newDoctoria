<?php

namespace App\Exports;

use App\Models\Pharmacy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PharmacyExport implements FromCollection, WithHeadings
{

    public function __construct()
    {
    }

    public function collection()
    {
        // Fetch users data based on the received $roomId
        $pharmacies =Pharmacy::select('cashback','discount','work_from','work_to','location')->get();
        return $pharmacies;
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
        ];
    }
}
