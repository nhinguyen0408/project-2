<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Regency;
use App\Models\Salary;
use App\Models\Shift;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search != null) {
            $idRegency = null;
            $listEmployees = Employee::where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
            ->join('regency', 'employees.regency_id', '=', 'regency.id')
            ->join('shift', 'employees.shift_id', '=', 'shift.id')
            ->select(
                'employees.*',
                'regency.id as regency_id',
                'regency.name_reg',
                'shift.id as shift_id',
                'shift.shift_name'
            )
                ->paginate(7);
        } else {
            $search = null;
            $idRegency = $request->get('regency_id');
            $listEmployees = Employee::join('regency', 'employees.regency_id', '=', 'regency.id')
            ->join('shift', 'employees.shift_id', '=', 'shift.id')
            ->where('regency_id', "$idRegency")
                ->select(
                    'employees.*',
                    'regency.id as regency_id',
                    'regency.name_reg',
                    'shift.id as shift_id',
                    'shift.shift_name'
                )
            ->paginate(7);
        }

        $listRegency = Regency::all();
        $listShift = Shift::all();
        return view('layouts.website.employees.mgn_employees', [
            "listEmployee" => $listEmployees,
            "search" => $search,
            "listShift" => $listShift,
            "listRegency" => $listRegency,
            "idRegency" => $idRegency,
            "page_title" => "Quản Lý Nhân Viên"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listRegency = Regency::all();
        $listShift = Shift::all();
        $listSalary = Salary::all();
        return view('layouts.website.employees.create', [
            "listRegency" => $listRegency,
            "listShift" => $listShift,
            "listSalary" => $listSalary,
            "page_title" => "Thêm Nhân Viên"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $first_name = $request->get("first_name");
        $last_name = $request->get("last_name");
        $gender = $request->get("gender");
        $address = $request->get("address");
        $email = $request->get("email");
        $phone = $request->get("phone");
        $regency_id = $request->get("regency_id");
        $shift_id = $request->get("shift_id");
        $salary_id = $request->get("salary_id");
        $employee = new Employee([
            'first_name' => $request->get("first_name"),
            'last_name' => $last_name,
            'address' => $address,
            'gender' => $gender,
            'email' => $email,
            'phone' => $phone,
            'regency_id' => $regency_id,
            'salary_id' => $salary_id,
            'shift_id' => $shift_id,
            'leave' =>0,
        ]);

        $employee->save();
        return redirect(route('employees.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::join('regency', 'employees.regency_id', '=', 'regency.id')
        ->join('shift', 'employees.shift_id', '=', 'shift.id')
        ->where('employees.id', $id)
            ->select(
                'employees.*',
                'regency.id as regency_id',
                'regency.name_reg',
                'shift.id as shift_id',
                'shift.shift_name'
            )
            ->first();
        $listRegency = Regency::all();
        $listShift = Shift::all();
        $listSalary = Salary::all();
        return view('layouts.website.employees.edit', [
            "employee" => $employee,
            "listRegency" => $listRegency,
            "listShift" => $listShift,
            "listSalary" => $listSalary,
            "page_title" => "Sửa Thông Tin Nhân Viên"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Employee::where('id', $id)->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'address'  => $request->get('address'),
            'gender' => $request->get('gender'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'regency_id' => $request->get('regency_id'),
            'salary_id' => $request->get('salary_id'),
            'shift_id' => $request->get('shift_id')
        ]);
        return redirect(route('employees.index'));

        // chua update duoc loi regency_id
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Employee::where('id', $id)->delete();

        return redirect(route('employees.index'));
    }

}
