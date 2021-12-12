<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OverTime;
use App\Models\OnLeave;
use App\Models\LeaveVoluntarily;
use App\Models\TimeKeeping;
use App\Models\WorkingHours;
use App\Models\LateTime;
use App\Models\Salary;
use App\Models\SalaryDetails;
use App\Models\RegulationDetails;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class TimeManager extends Controller
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

        $data['page_title'] = 'Quản lý giờ làm';
        return view('layouts.website.timeManager.index', $data);
    }
    public function details($id){
        $check_month = TimeKeeping::first();
        if(isset($check_month)){
            $month = date('m', strtotime($check_month->checked));
            $data['month'] = $month;
            $check_working = WorkingHours::where('employee_id', $id)->first();
            $on_leave = OnLeave::where('employee_id', $id);
            $employee = Employee::find($id);
            $data['employee'] =  $employee;
            $data['on_leave'] = ($on_leave != null) ? $on_leave : null;
            $data['employee_name'] = $employee->first_name .' ' . $employee->last_name;
            if(isset($check_working)){
                $working_details = WorkingHours::join('employees','working_hours.employee_id','=','employees.id')
                ->where('working_hours.employee_id', $id)
                ->select(
                    'working_hours.*',
                    'employees.first_name',
                    'employees.last_name',
                    'employees.regency_id',
                    'employees.shift_id'
                    )->get();
                $data['working_details'] = $working_details;
            } else {
                $data['working_details'] = null;
            }
        }else{
            $data['month'] = null;
        }

        $data['page_title'] = 'Quản lý giờ làm';
        return view('layouts.website.timeManager.details', $data);
    }
    public function onLeave(Request $request){
        $check_on_leave = OnLeave::where('employee_id', $request->employee_id)->first();
        $employee = Employee::find($request->employee_id);
        $leave = $employee->leave;
        if($leave >= 1){
            $fill = new OnLeave(['employee_id'=>$request->employee_id, 'day'=> $request->day, 'month'=> $request->month]);
            $fill->save();
            DB::table('employees')->where('id', $request->employee_id)->update(['leave'=> $leave - 1]);
            SalaryController::salary_calculation();
        }
    }
    public function offLeave(Request $request){
        $check_on_leave = OnLeave::where('employee_id', $request->employee_id)->first();
        if($check_on_leave != null){
            DB::table('on_leave')->where('employee_id', $request->employee_id)->where('day', $request->day)->delete();
            $employee = Employee::find($request->employee_id);
            $leave = $employee->leave;
            DB::table('employees')->where('id', $request->employee_id)->update(['leave'=> $leave + 1]);
            SalaryController::salary_calculation();
        }
    }
    // xử lý nghỉ không phép
    public function leave_voluntarily(Request $request){

            $fill = new LeaveVoluntarily(['employee_id'=>$request->employee_id, 'day'=> $request->day, 'month'=> $request->month]);
            $fill->save();
            $regulation = new RegulationDetails(['employee_id' => $request->employee_id, 'regulation_id' =>13]);
            $regulation->save();
            SalaryController::salary_calculation();

    }
    public function delete_leave_voluntarily(Request $request){
        $check_leave_voluntarily = LeaveVoluntarily::where('employee_id', $request->employee_id)->first();
        if($check_leave_voluntarily != null){
            DB::table('leave_voluntarily')->where('employee_id', $request->employee_id)->where('day', $request->day)->delete();
            $check = DB::table('regulation_details')->where('employee_id', $request->employee_id)->where('regulation_id', 13)->first();
            if($check != null){
                DB::table('regulation_details')->where('employee_id', $request->employee_id)->where('regulation_id', 13)->limit(1)->delete();
            }
            SalaryController::salary_calculation();
        }
    }
}
