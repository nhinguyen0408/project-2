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
        if ($search != null) {
            $time_keeping = TimeKeeping::join('employees', 'time_keeping.employee_id', '=', 'employees.id')
            ->where('employees.last_name', 'like', "%$search%")
            ->orwhere('employees.first_name', 'like', "%$search%")
            ->get();
            $data['time_keeping'] = $time_keeping;
            $data['search'] = $search;
            $data['important'] = null;
        } else {
            $important = '<h3>Tìm tên nhân viên để xem lịch sử chấm công !!!</h3>';
            $data['time_keeping'] = null;
            $data['search'] = null;
            $data['important'] = $important;
        }
        $data['page_title'] = "Chấm công";
        return view('layouts.website.time-keeping.index', $data);
    }

    public function importExcel(Request $request)
    {
        Excel::import(new TimeKeepingImport, $request->file('excel'));
        echo "done";
    }
}
