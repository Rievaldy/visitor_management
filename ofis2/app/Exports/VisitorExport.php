<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Visitor;
use DB;

class VisitorExport implements FromView
{
    public function view(): View
    {
        return view('Export._visitor', [
            'visitor' => Visitor::all()
        ]);
    }
}
