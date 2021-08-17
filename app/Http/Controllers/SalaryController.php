<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\OverTime;
use App\Models\TimeKeeping;
use App\Models\WorkingHours;
use App\Models\LateTime;
use App\Models\Salary;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function index(){
        $check_month = TimeKeeping::first();
        if(isset($check_month)){
            $month = date('m', strtotime($check_month->checked));
            $data['month'] = $month;
        }else{
            $data['month'] = null;
        }
        $data['page_title'] = 'Tính lương';
        return view('layouts.website.salary.get_salary', $data);
    }

    public function salary_calculation()
    {
        $check_time_keeping = TimeKeeping::first();
        if(isset($check_time_keeping)){
            $employee = Employee::all();
            foreach ($employee as $val_em) {
                $time_keeping = TimeKeeping::where('employee_id', $val_em->id)->get();
                // test 
                $salary = Salary::where('id',$val_em->salary_id)->first();
                if($val_em->regency_id == 1){
                    $total_working = WorkingHours::where('employee_id', $val_em->id)->where('status',1)->get()->count();
                    $earning = $total_working* $salary->earnings;
                    dd($earning);
                }

                //
                foreach ($time_keeping as $val_time) {
                    //$day = $val_time->checked;
                    $day = date('Y-m-d', strtotime($val_time->checked));
                    //dd(date('Y-m-d', strtotime($val_time->checked)));
                    $day_working = TimeKeeping::where('employee_id', $val_em->id)->where('checked', 'like', "%$day%")->get();
                    if (count($day_working) >= 2) {
                        $hour = abs(strtotime(date('H:i:s', strtotime($day_working->max('checked')))) - strtotime(date('H:i:s', strtotime('08:00:00'))));
                        $hour_late = abs(strtotime(date('H:i:s', strtotime($day_working->min('checked')))) - strtotime(date('H:i:s', strtotime('08:00:00'))));
                        $hour_working = number_format($hour/3600, 2) - 1.5;
                        $late = number_format($hour_late/3600, 2);
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
                        $check_late = LateTime::where('day', $day)->first();
                        if($check_late == null) {
                            $store_late = new LateTime([
                                'employee_id' => $val_em->id,
                                'day' => $day,
                                'hours' => $late
                            ]);
                            $store_late->save();
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
                
                // XU LY TINH LUONG
                $salary = Salary::where('id',$val_em->salary_id)->first();
                if($val_em->regency_id == 1){
                    $total_working = WorkingHours::where('employee_id', $val_em->id)->where('status',1)->get()->count();
                    $earning = $total_working* $salary->earnings;
                    dd($earning);
                }
            }
        } else {
            print_r("Please import Check-in/ Check-out");
        }
        return redirect()->back();
    }

}
