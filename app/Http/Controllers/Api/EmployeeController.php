<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Imports\EmployeesImport;
use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    // Searchable/sortable/paginated listing
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);
        $search  = $request->get('search');          // matches name/email
        $deptId  = $request->get('department_id');   // numeric id
        $sortBy  = $request->get('sort_by', 'joining_date'); // salary|joining_date|name|created_at
        $sortDir = $request->get('sort_dir', 'desc');        // asc|desc

        $allowedSorts = ['salary','joining_date','name','created_at'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'joining_date';
        $sortDir = $sortDir === 'asc' ? 'asc' : 'desc';

        $q = Employee::with('department');

        if ($search) {
            $q->where(function($qq) use ($search) {
                $qq->where('name','like',"%{$search}%")
                   ->orWhere('email','like',"%{$search}%");
            });
        }

        if ($deptId) $q->where('department_id', $deptId);

        $paginated = $q->orderBy($sortBy, $sortDir)
                       ->paginate($perPage)
                       ->appends($request->query());

        return response()->json($paginated);
    }

    public function store(EmployeeRequest $request)
    {
        $emp = Employee::create($request->validated());
        return response()->json($emp, 201);
    }

    public function show(Employee $employee)
    {
        $employee->load('department');
        return response()->json($employee);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());
        return response()->json($employee);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // Import: skips invalid rows & logs errors
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xlsx,csv']);
        $import = new EmployeesImport();
        Excel::import($import, $request->file('file'));

        $failures = method_exists($import, 'failures') ? $import->failures() : [];
        foreach ($failures as $f) {
            Log::warning('Import failure at row '.$f->row().': '.implode(' | ', $f->errors()));
        }

        return response()->json(['message'=>'Import finished', 'failed_rows'=>count($failures)]);
    }

    // Export: optional ?department=IT (by name)
    public function export(Request $request)
    {
        $dept = $request->get('department');
        $file = 'employees' . ($dept ? "_{$dept}" : '') . '.xlsx';
        return Excel::download(new EmployeesExport($dept), $file);
    }
}
