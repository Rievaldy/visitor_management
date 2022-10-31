<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\LockerLog;
use DB;

class LockerExport implements FromView
{
    public function view():View
    {
        return view('Export._locker', [
            'locker' => LockerLog::all()
        ]);
    }
}
