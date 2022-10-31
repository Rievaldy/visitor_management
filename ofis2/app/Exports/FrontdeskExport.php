<?php

namespace App\Exports;

use App\Models\Frontdesk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FrontdeskExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return[
            // 'No.',
            'Request Date',
            'Request Time',
            'Room Name',
            'Meeting Start',
            'Meeting End',
            'Message',
            'Request Status',
        ];
    }

    public function collection(){
        return collect(Frontdesk::getReport());
    }

}


