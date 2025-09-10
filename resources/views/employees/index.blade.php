@extends('layouts.dashboard')

@section('content')
<h2>Employees</h2>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex mb-3">
  <a href="{{ route('employees.web.create') }}" class="btn btn-success me-2">+ Add Employee</a>

  <!-- Export Button -->
  <a href="{{ url('/api/employees/export') }}" class="btn btn-primary me-2">
    ⬇️ Export Employees
  </a>

  <!-- Import Form -->
  <form action="{{ url('/api/employees/import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-info">⬆️ Import</button>
  </form>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Name</th><th>Email</th><th>Department</th>
      <th>Salary</th><th>Joining Date</th><th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($employees as $emp)
    <tr>
      <td>{{ $emp['id'] }}</td>
      <td>{{ $emp['name'] }}</td>
      <td>{{ $emp['email'] }}</td>
      <td>{{ $emp['department']['name'] ?? 'N/A' }}</td>
      <td>{{ $emp['salary'] }}</td>
      <td>{{ $emp['joining_date'] }}</td>
      <td>
        <a href="{{ route('employees.web.edit', $emp['id']) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('employees.web.destroy', $emp['id']) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
