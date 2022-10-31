<?php

namespace App\Exports;

use App\Models\BookNowParticipant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MeetingParticipantsExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return[
            // 'No.',
            'Meeting Date',
            'Room Name',
            'Meeting Start',
            'Meeting End',
            'Participant Name',
            'Participant Email',
            'Participant Company',
            'Participant Phone',
            'Status',
            'Present At',
        ];
    }

    public function collection(){
        return collect(BookNowParticipant::getReport());
    }

}


