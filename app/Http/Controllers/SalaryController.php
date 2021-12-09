<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\OverTime;
use App\Models\OnLeave;
use App\Models\TimeKeeping;
use App\Models\WorkingHours;
use App\Models\LateTime;
use App\Models\Salary;
use App\Models\SalaryDetails;
use App\Models\RegulationDetails;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function index(){
        $check_month = TimeKeeping::first();
        if(isset($check_month)){
            $month = date('m', strtotime($check_month->checked));
            $data['month'] = $month;
            $check_salary_details = SalaryDetails::where('month', $month)->first();
            if(isset($check_salary_details)){
                $salary_details = SalaryDetails::join('employees','salary_details.employee_id','=','employees.id')
                ->where('month', $month)
                ->select(
                    'salary_details.*',
                    'employees.first_name',
                    'employees.last_name',
                    'employees.regency_id',
                    'employees.shift_id'
                    )->get();
                $data['data_salary'] = $salary_details;
            } else {
                $data['data_salary'] = null;
            }
        }else{
            $data['month'] = null;
        }

        $data['page_title'] = 'Tính lương';
        return view('layouts.website.salary.get_salary', $data);
    }

    public static function salary_calculation()
    {
        $check_time_keeping = TimeKeeping::first();
        $month = date('m', strtotime($check_time_keeping->checked));
        if(isset($check_time_keeping)){ // ktra có bản ghi thì chạy

            $check_month = TimeKeeping::first();
            $employee = Employee::all();
            foreach ($employee as $val_em) { // chạy lần lượt từng nhân viên
                $time_keeping = TimeKeeping::where('employee_id', $val_em->id)->get(); // lấy dữ liệu chấm công
                foreach ($time_keeping as $val_time) {
                    //$day = $val_time->checked;
                    $day = date('Y-m-d', strtotime($val_time->checked));
                    //dd(date('Y-m-d', strtotime($val_time->checked)));
                    $day_working = TimeKeeping::where('employee_id', $val_em->id)->where('checked', 'like', "%$day%")->get(); // lấy dữ liệu các ngày giống nhau
                    if (count($day_working) >= 2) { // check in check out đủ
                        $hour = abs(strtotime(date('H:i:s', strtotime($day_working->max('checked')))) - strtotime(date('H:i:s', strtotime('08:00:00'))));
                        $hour_late = abs(strtotime(date('H:i:s', strtotime($day_working->min('checked')))) - strtotime(date('H:i:s', strtotime('08:00:00'))));
                        $hour_working_total = number_format($hour/3600, 2) - 1.5;
                        $late = number_format($hour_late/3600, 2);
                        $status = 1;
                        if ($hour_working_total > 8) { // nếu làm quá 8h thực hiện nhập liệu vào bảng làm thêm
                            $overtime = $hour_working_total - 8;
                            $check_overtime = OverTime::where('day', $day)->where('employee_id',$val_em->id)->first();
                            if ($check_overtime == null) {
                                $store_overtime = new OverTime([
                                    'employee_id' => $val_em->id,
                                    'day' => $day,
                                    'hours' => $overtime
                                ]);
                                $store_overtime->save();
                            }
                            $hour_working = 8;
                        }
                        // Xử lý làm muộn giờ
                        $check_late = LateTime::where('day', $day)->where('employee_id',$val_em->id)->first();
                        if($check_late == null) {
                            $store_late = new LateTime([
                                'employee_id' => $val_em->id,
                                'day' => $day,
                                'hours' => $late
                            ]);
                            $store_late->save();
                        }
                    } elseif (count($day_working) > 0) { // check in check out thiếu
                        $hour = abs(strtotime(date('H:i:s', strtotime($day_working->max('checked')))) - strtotime(date('H:i:s', strtotime('12:00:00'))));
                        $check_hour = number_format($hour/3600, 2) - 1.5;
                        if($check_hour > 0) {
                            $hour_working = $check_hour;
                            $status = 1;
                        } else {
                            $hour_working = 0;
                            $status = 0;
                        }

                    }
                    // nhập liệu vào bảng working_hours
                    try {
                        $working = WorkingHours::where('day', $day)->where('employee_id', $val_em->id)->first();
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
                // xử lý thưởng chuyên cần
                $total_working = WorkingHours::where('employee_id', $val_em->id)->where('status',1)->get()->count();
                    if($total_working >= 29){
                        $check_bonus = RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',1)->first();
                        $check_late = LateTime::where('hours', '>',0.5)->where('employee_id',$val_em->id)->get()->count();
                        if($check_late <=3){
                            if(isset($check_bonus)){

                            } else {
                                $bonus = new RegulationDetails([
                                    'employee_id'=> $val_em->id,
                                    'regulation_id' => 1,
                                ]);
                                $bonus->save();
                            }
                        }

                    }
                    // xử lý phạt đi muộn
                $total_late_day = LateTime::where('hours', '>',0.5)->where('employee_id',$val_em->id)->get()->count();
                    if($total_late_day >= 10){
                        $check_late = RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',10)->first();
                        $check_late_2 = RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',8)->first();
                        $check_late_3 = RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',9)->first();
                        if(isset($check_late_2)){
                            RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',8)->delete();
                        }
                        if(isset($check_late_3)){
                            RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',9)->delete();
                        }
                        if(!isset($check_late)){
                            $late = new RegulationDetails([
                                'employee_id'=> $val_em->id,
                                'regulation_id' => 10,
                            ]);
                            $late->save();
                        }
                    } else if($total_late_day >= 5){
                        $check_late = RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',9)->first();
                        $check_late_2 = RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',8)->first();
                        if(isset($check_late_2)){
                            RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',8)->delete();
                        }
                        if(!isset($check_late)){
                            $late = new RegulationDetails([
                                'employee_id'=> $val_em->id,
                                'regulation_id' => 9,
                            ]);
                            $late->save();
                        }
                    } else if($total_late_day >= 3){
                        $check_late = RegulationDetails::where('employee_id', $val_em->id)->where('regulation_id',8)->first();
                        if(!isset($check_late)){
                            $late = new RegulationDetails([
                                'employee_id'=> $val_em->id,
                                'regulation_id' => 8,
                            ]);
                            $late->save();
                        }
                    }
                // XU LY TINH LUONG
                $salary = Salary::where('id',$val_em->salary_id)->first();
                    // tính thưởng
                $bonus_earning = RegulationDetails::join('regulation','regulation_details.regulation_id','=','regulation.id')
                    ->where('regulation_details.employee_id',$val_em->id)
                    ->where('status',1)->get();
                $total_bonus_earning = 0;
                if(isset($bonus_earning)){
                    foreach ($bonus_earning as $val_bonus){
                        $total_bonus_earning =  $total_bonus_earning + $val_bonus->amount_of_money;
                    }
                }
                    // tính phạt
                $penalize = RegulationDetails::join('regulation','regulation_details.regulation_id','=','regulation.id')
                ->where('regulation_details.employee_id',$val_em->id)
                ->where('status',0)->get();
                $total_penalize = 0;
                if(isset($penalize)){
                    foreach ($penalize as $val_pen){
                        $total_penalize =  $total_penalize + $val_pen->amount_of_money;
                    }
                }
                    // tính tổng tăng ca
                $get_over_time = OverTime::where('employee_id',$val_em->id)->get();
                $total_over_time = 0;
                foreach ($get_over_time as $val_over){
                    $total_over_time =$total_over_time + $val_over->hours;
                }
                    // Tính lương
                if($val_em->regency_id == 1 || $val_em->regency_id == 4 || $val_em->regency_id == 6){
                    $total_on_leave = OnLeave::where('employee_id', $val_em->id)->get()->count();
                    $total_working_day = WorkingHours::where('employee_id', $val_em->id)->where('status',1)->get()->count();
                    $earning = ($total_working_day + $total_on_leave) * $salary->earnings + ($salary->earnings/8) * 1.4 * $total_over_time;
                    $total_time = $total_working_day + $total_on_leave;
                } else {
                    $worked = WorkingHours::where('employee_id', $val_em->id)->where('status',1)->get();
                    $total_working_hours = 0;
                    foreach($worked as $item){
                        $total_working_hours = $total_working_hours + $item->hours;
                    }
                    $earning = $total_working_hours* $salary->earnings + $total_over_time * $salary->earnings *1.4;
                    $total_time = $total_working_hours + $total_over_time;
                }
                $check_salary_details = SalaryDetails::where('employee_id', $val_em->id)->where('month', $month)->first();
                if(!isset($check_salary_details)){
                    $salary_details = new SalaryDetails([
                        'employee_id' => $val_em->id,
                        'month' => $month,
                        'salary_earning' => $earning,
                        'total_time' => $total_time,
                        'bonus_earning' => $total_bonus_earning,
                        'penalize' => $total_penalize
                    ]);
                    $salary_details->save();
                } else {
                    $check_salary_details->employee_id = $val_em->id;
                    $check_salary_details->month = $month;
                    $check_salary_details->salary_earning = $earning;
                    $check_salary_details->total_time = $total_time;
                    $check_salary_details->bonus_earning = $total_bonus_earning;
                    $check_salary_details->penalize = $total_penalize;
                    $check_salary_details->save();
                }

            }
        } else {
            print_r("Please import Check-in/ Check-out");
        }
        return redirect()->back();
    }

    public function details($id) {
        $check_month = TimeKeeping::first();
        if(isset($check_month)){
            $month = date('m', strtotime($check_month->checked));
            $data['month'] = $month;
            $check_salary_details = SalaryDetails::where('month', $month)->where('employee_id',$id)->first();
            $over_time = OverTime::where('employee_id',$id)->get();
            $total_over_time = 0;
            foreach ($over_time as $item){
                $total_over_time += $item->hours;
            }
            $employee = Employee::find($id);
            $regulations = RegulationDetails::join('regulation','regulation_details.regulation_id','=','regulation.id')->where('regulation_details.employee_id',$id)->get();
            $data['employee'] =  $employee;
            $data['regulations'] =  $regulations;
            $data['overtime'] =  $total_over_time;
            $data['employee_name'] = $employee->first_name .' ' . $employee->last_name;
            if(isset($check_salary_details)){
                $salary_details = SalaryDetails::join('employees','salary_details.employee_id','=','employees.id')
                ->where('month', $month)->where('employee_id', $id)
                ->select(
                    'salary_details.*',
                    'employees.first_name',
                    'employees.last_name',
                    'employees.regency_id',
                    'employees.shift_id'
                    )->first();
                $data['data_salary'] = $salary_details;
            } else {
                $data['data_salary'] = null;
            }
        }else{
            $data['month'] = null;
        }

        $data['page_title'] = 'Chi tiết lương';
        return view('layouts.website.salary.details', $data);
    }

}
