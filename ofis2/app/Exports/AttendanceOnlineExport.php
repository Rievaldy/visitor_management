<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceOnlineExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return[
            // 'No.',
            'Date',
            'Employee Name',
            'Emplyee ID',
            'Check In',
            'Check Out'
        ];
    }

    public function collection(){
        return collect(Attendance::getReport());
    }

}

