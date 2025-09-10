@extends('layouts.app')

@section('content')
<h2>Edit Employee</h2>
<form action="{{ route('employees.web.update', $employee->id) }}" method="POST" class="card p-3">
  @csrf @method('PUT')
  <div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ $employee['name'] }}" required>
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ $employee['email'] }}" required>
  </div>
  <div class="mb-3">
    <label>Salary</label>
    <input type="number" name="salary" class="form-control" value="{{ $employee['salary'] }}" required>
  </div>
  <div class="mb-3">
    <label>Joining Date</label>
    <input type="date" name="joining_date" class="form-control" value="{{ $employee['joining_date'] }}" required>
  </div>
  <div class="mb-3">
    <label>Department ID</label>
    <input type="number" name="department_id" class="form-control" value="{{ $employee['department_id'] }}" required>
  </div>
  <button class="btn btn-warning">Update</button>
  <a href="{{ route('employees.web.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
