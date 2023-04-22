<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class APIDepartmentController extends Controller
{
    private $department;
    
    public function __construct(DepartmentService $department)
    {
        $this->department = $department;
    }

    public function index()
    {
        return response()->json($this->department->index());
    }

    public function show($id)
    {
        return response()->json($this->department->show($id));
    }

    public function store(Request $request)
    {
        $department = $this->department->store($request->all());
        return response()->json($department, 201);
    }

    public function update($id, Request $request)
    {
        $department = $this->department->update($id, $request->all());
        return response()->json($department);
    }

    public function destroy($id)
    {
        $department = $this->department->destroy($id);
        return response()->json([],204);
    }
}

?>