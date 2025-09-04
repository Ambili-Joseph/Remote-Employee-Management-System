<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return response()->json(Department::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:departments,name'
        ]);

        $department = Department::create($request->all());
        return response()->json($department, 201);
    }

    public function show($id)
    {
        return Department::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|unique:departments,name,' . $department->id
        ]);

        $department->update($validated);

        return response()->json([
            'message' => 'Department updated successfully',
            'data' => $department
        ]);
    }

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();

        return response()->json(['message' => 'Department deleted successfully']);
    }
}
