@extends('layouts.app')

@section('content')
<h2>Add Employee</h2>
<form action="{{ route('employees.web.store') }}" method="POST" class="card p-3">
  @csrf
  <div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Salary</label>
    <input type="number" name="salary" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Joining Date</label>
    <input type="date" name="joining_date" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Department ID</label>
    <input type="number" name="department_id" class="form-control" required>
  </div>
  <button class="btn btn-success">Save</button>
  <a href="{{ route('employees.web.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
