<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Department;

class DepartmentWebController extends Controller
{
    private $api = 'http://127.0.0.1:8000/api/departments';

    public function index()
    {
    $departments = Department::all();

    return response()->json([
        'message' => 'Departments fetched successfully',
        'data' => $departments
    ], 200);
}
    // {
    //     $departments = Http::get($this->api)->json();
    //     return view('departments.index', compact('departments'));
    // }

    public function create()
    {
        // return view('departments.create');
        $departments = Department::all(); // instead of HTTP request
    return view('departments.create', compact('departments'));
    }

    public function store(Request $request)
    {
        Http::post($this->api, $request->all());
        return redirect()->route('departments.web.index')->with('success', 'Department created');
    }

    public function edit($id)
    {
        $department = Http::get("{$this->api}/{$id}")->json();
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        Http::put("{$this->api}/{$id}", $request->all());
        return redirect()->route('departments.web.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        Http::delete("{$this->api}/{$id}");
        return redirect()->route('departments.web.index')->with('success', 'Deleted');
    }
}
