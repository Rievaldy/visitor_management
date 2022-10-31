<?php

namespace App\Exports;

use App\Models\BookNowFnB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FnBExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return[
            // 'No.',
            'Date',
            'Room Name',
            'Start Time',
            'End Time',
            'Menu Name',
            'Qty',
            'Order Status',
        ];
    }

    public function collection(){
        return collect(BookNowFnB::getReport());
    }

}

