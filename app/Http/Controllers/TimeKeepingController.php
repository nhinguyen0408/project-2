<?php

namespace App\Http\Controllers;

use App\Imports\TimeKeepingImport;
use App\Models\Employee;
use App\Models\OverTime;
use App\Models\TimeKeeping;
use App\Models\WorkingHours;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class TimeKeepingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $check_time_keeping = TimeKeeping::first();
        if(isset($check_time_keeping))
        {
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
        }else{
            $data['time_keeping'] = null;
            $data['search'] = null;
            $data['important'] = null;
        }
        $check_month = TimeKeeping::first();
        if(isset($check_month)){
            $month = date('m', strtotime($check_month->checked));
            $data['month'] = $month;
        }else{
            $data['month'] = null;
        }
        $data['page_title'] = "Chấm công";
        return view('layouts.website.time-keeping.index', $data);
    }

    public function view($id)
    {
        $check_month = TimeKeeping::first();
        if(isset($check_month)){
            $month = date('m', strtotime($check_month->checked));
            $data['month'] = $month;
        }else{
            $data['month'] = null;
        }
        $employee_time_keeping = TimeKeeping::join('employees', 'time_keeping.employee_id', '=', 'employees.id')
        ->where('employees.id', $id)->get();
        $data['employee_time_keeping'] = $employee_time_keeping;
        $data['page_title'] = "Chấm công";
        return view('layouts.website.time-keeping.index', $data);
    }

    public function working($id)
    {
        $check_month = TimeKeeping::first();
        if(isset($check_month)){
            $month = date('m', strtotime($check_month->checked));
            $data['month'] = $month;
        }else{
            $data['month'] = null;
        }
        $data['page_title'] = "Xem Giờ Làm";
        return view('layouts.website.time-keeping.index', $data);
    }

    public function importExcel(Request $request)
    {
        Excel::import(new TimeKeepingImport, $request->file('excel'));
        return redirect()->back();
    }
    public function reset(){
        DB::table('time_keeping')->delete();
        DB::table('overtime')->delete();
        DB::table('working_hours')->delete();
        DB::table('late_time')->delete();
        return redirect()->back();
    }
}
