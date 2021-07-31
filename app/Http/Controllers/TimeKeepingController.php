<?php

namespace App\Http\Controllers;

use App\Imports\TimeKeepingImport;
use App\Models\TimeKeeping;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TimeKeepingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $time_keeping = TimeKeeping::join('employees', 'time_keeping.employee_id', '=', 'employees.id')
            ->where('employees.last_name', 'like', "%$search%")
            ->orwhere('employees.first_name', 'like', "%$search%")
            ->get();
        $data['time_keeping'] = $time_keeping;
        $data['search'] = $search;
        return view('layouts.website.time-keeping.index', $data);
    }

    public function importExcel(Request $request)
    {
        Excel::import(new TimeKeepingImport, $request->file('excel'));
        echo "done";
    }
}
