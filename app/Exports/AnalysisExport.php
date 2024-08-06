<?php

namespace App\Exports;

use App\Models\Analysis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnalysisExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
    }

    public function collection()
    {
        // Fetch users data based on the received $roomId
        $rows =Analysis::select('price','laboratory_id')->get();
        return $rows;
    }

    public function headings(): array
    {
        // Define column headers
        return [
            'price',
            'laboratory_id',
            'name_en',
            'name_ar',
            // Add more column names as needed
        ];
    }
}
