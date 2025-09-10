<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;

class EmployeeWebController extends Controller
{
    private $api = 'http://127.0.0.1:8000/api/employees';

    public function index(Request $request) {
      $query = \App\Models\Employee::with('department');

    if ($request->filled('search')) {
        $search = $request->get('search');
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
    }

    if ($request->filled('department_id')) {
        $query->where('department_id', $request->department_id);
    }

    $employees = $query->orderBy(
        $request->get('sort_by', 'id'),
        $request->get('sort_dir', 'asc')
    )->paginate($request->get('per_page', 10));

    return view('employees.index', compact('employees'));;
    }

    public function create() { 
        // return view('employees.create'); 
        $departments =Department::all();
    return view('employees.create', compact('departments'));
    }

    public function store(Request $request) {
        Http::post($this->api, $request->all());
        return redirect()->route('employees.web.index')->with('success', 'Employee added');
    }
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'departments'));
    }
    public function update(Request $request, Employee $employee, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')
                         ->with('success', 'Employee updated successfully!');
    }
    public function destroy($id)
    {
        Http::delete("{$this->api}/{$id}");
        return redirect()->route('employees.web.index')->with('success', 'Deleted');
    }
    
}
