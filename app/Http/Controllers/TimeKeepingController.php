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

    public function view($id)
    {
        $employee_time_keeping = TimeKeeping::join('employees', 'time_keeping.employee_id', '=', 'employees.id')
        ->where('employees.id', $id)->get();
        $data['employee_time_keeping'] = $employee_time_keeping;
        $data['page_title'] = "Chấm công";
        return view('layouts.website.time-keeping.index', $data);
    }

    public function working($id)
    {
        $data['page_title'] = "Xem Giờ Làm";
        return view('layouts.website.time-keeping.index', $data);
    }

    public function salary_calculation()
    {
        $employee = Employee::all();
        foreach ($employee as $val_em) {
            $time_keeping = TimeKeeping::where('employee_id', $val_em->id)->get();
            foreach ($time_keeping as $val_time) {
                //$day = $val_time->checked;
                $day = date('Y-m-d', strtotime($val_time->checked));
                //dd(date('Y-m-d', strtotime($val_time->checked)));
                $day_working = TimeKeeping::where('employee_id', $val_em->id)->where('checked', 'like', "%$day%")->get();
                if (count($day_working) >= 2) {
                    $hour = abs(strtotime(date('H:i:s', strtotime($day_working->max('checked')))) - strtotime(date('H:i:s', strtotime('08:00:00'))));
                    $hour_working = number_format(date('H.n', $hour), 2) - 1.5;
                    $status = 1;
                    if ($hour_working > 8) {
                        $overtime = $hour_working - 8;
                        $check_overtime = OverTime::where('day', $day)->first();
                        if ($check_overtime == null) {
                            $store_overtime = new OverTime([
                                'employee_id' => $val_em->id,
                                'day' => $day,
                                'hours' => $overtime
                            ]);
                            $store_overtime->save();
                        }
                    }
                } elseif (count($day_working) > 0) {
                    $hour_working = 0;
                    $status = 0;
                }
                try {

                    $working = WorkingHours::where('day', $day)->first();

                    if (isset($working) && count($working)) {
                    } else {
                        $store = new WorkingHours([
                            'employee_id' => $val_em->id,
                            'day' => $day,
                            'hours' => $hour_working,
                            'status' => $status
                        ]);

                        $store->save();
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
    }

    public function importExcel(Request $request)
    {
        Excel::import(new TimeKeepingImport, $request->file('excel'));
    }
}
