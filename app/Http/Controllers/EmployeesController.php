<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Regency;
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
        $idRegency = $request->get('regency_id');
        $idShift = $request->get('shift_id');
        $listEmployees = Employee::where('first_name', 'like', "%$search%")
            ->join('regency', 'employees.regency_id', '=', 'regency.id')
            ->join('shift', 'employees.shift_id', '=', 'shift.id')
            ->where('regency_id', "$idRegency")
            ->where('shift_id', "$idShift")
            ->paginate(10);
        $listRegency = Regency::all();
        $listShift = Shift::all();
        return view('layouts.employees.mgn_employees', [
            "listEmployee" => $listEmployees,
            "search" => $search,
            "listShift" => $listShift,
            "listRegency" => $listRegency,
            "idShift" => $idShift,
            "idRegency" => $idRegency
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
    }
}
