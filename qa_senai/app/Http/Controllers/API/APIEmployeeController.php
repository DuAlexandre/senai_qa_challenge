<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class APIEmployeeController extends Controller
{
    private $employee;
    
    public function __construct(EmployeeService $employee)
    {
        $this->employee = $employee;
    }

    public function index()
    {
        return response()->json($this->employee->index());
    }

    public function show($id)
    {
        return response()->json($this->employee->show($id));
    }

    public function store(Request $request)
    {
        $employee = $this->employee->store($request->all());
        return response()->json($employee, 201);
    }

    public function update($id, Request $request)
    {
        $employee = $this->employee->update($id, $request->all());
        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = $this->employee->destroy($id);
        return response()->employee([],204);
    }
}

?>