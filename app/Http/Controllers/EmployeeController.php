<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index(){
        return view('home');
    }
    
    public function store(Request $request)
    {
        $empData = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone
        ];
        Employee::create($empData);
        return response()->json([
            'status' => 200,
        ]);
    }
    public function getall()
    {
        $employees = Employee::all();
        return response()->json([
            'status' => 200,
            'employees' => $employees
        ]);
    }
    public function edit($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Employee not found'
            ]);
        }
    }
    public function update(Request $request)
    {
        $employee = Employee::find($request->id);
        if ($employee) {
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->phone = $request->phone;
            $employee->save();
            return response()->json([
                'status' => 200,
                'message' => 'Employee updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Employee not found'
            ]);
        }
    }
    public function delete(Request $request)
    {
        $employee = Employee::find($request->id);
        if ($employee && $employee->delete()) {
            return response()->json(['status' => 200, 'message' => 'Employee deleted successfully.']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Failed to delete employee.']);
        }
    }
}
