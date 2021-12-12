<?php

namespace App\Http\Controllers;

use App\Models\Regulation;
use App\Models\Employee;
use App\Models\TimeKeeping;
use App\Models\SalaryDetails;
use App\Models\RegulationDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegulationController extends Controller
{
    public function index(){
        $data['page_title'] = "Quản lý quy chế Thưởng phạt";
        $bonus_all = Regulation::where('status',3)->get();
        $employees = Employee::all();
        $regulation = Regulation::join('regulation_details','regulation.id','=','regulation_details.regulation_id')
        ->join('employees','employees.id','=','regulation_details.employee_id')
        ->where('status',2)->select('regulation.*','employees.first_name','employees.last_name','employees.id as employee_id')->get();
        $data['employees'] = $employees;
        $data['regulation'] = $regulation;
        $data['bonus_all'] = $bonus_all;
        return view('layouts.website.regulation.index',$data);
    }
    public function bonusAll(Request $request){
        $number = $request->number;
        $description = $request->description;
        $bonusAll = new Regulation(['amount_of_money'=>$number, 'description'=>$description, 'status'=>3]);
        $bonusAll->save();
        $employee = Employee::all();
        $bonus = Regulation::where('description',$description)->first();
        $check_time_keeping = TimeKeeping::first();
        $month = date('m', strtotime($check_time_keeping->checked));
        foreach($employee as $item){
            $check_salary = SalaryDetails::where('employee_id',$item->id)->where('month',$month)->first();
            if($check_salary->salary_earning > 0){
                $regulation = new RegulationDetails([
                    'employee_id'=> $item->id,
                    'regulation_id' => $bonus->id,
                ]);
                $regulation->save();
            }
        }
        SalaryController::salary_calculation();
    }

    public function abortBonus(Request $request){
        $id = $request->id;
        DB::table('regulation')->where('id',$id)->delete();
        DB::table('regulation_details')->where('regulation_id',$id)->delete();
        SalaryController::salary_calculation();
    }
    public function penazile(Request $request){
        $employee_id = $request->employee_id;
        $number = $request->number;
        $description = $request->description;
        $check_time_keeping = TimeKeeping::first();
        $month = date('m', strtotime($check_time_keeping->checked));
        $check_salary = SalaryDetails::where('employee_id',$employee_id)->where('month',$month)->first();
        if($check_salary != null && $check_salary->salary_earning > $number)
        {
            $penazile = new Regulation(['amount_of_money'=>$number, 'description'=>$description, 'status'=>2]);
            $penazile->save();
            $bonus = Regulation::where('description',$description)->first();
            $regulation = new RegulationDetails([
                'employee_id'=> $employee_id,
                'regulation_id' => $bonus->id,
            ]);
            $regulation->save();
            SalaryController::salary_calculation();
        }

    }
    public function abortPenazile(Request $request){
        $employee_id = $request->employee_id;
        $regulation_id = $request->regulation_id;
        DB::table('regulation')->where('id',$regulation_id)->delete();
        DB::table('regulation_details')->where('regulation_id',$regulation_id)->where('employee_id',$employee_id)->delete();
        SalaryController::salary_calculation();
    }
}
