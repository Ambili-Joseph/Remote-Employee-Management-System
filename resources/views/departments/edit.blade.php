@extends('layouts.app')

@section('content')
<h2>Edit Department</h2>
<form action="{{ route('departments.web.update', $department['id']) }}" method="POST" class="card p-3">
  @csrf @method('PUT')
  <div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ $department['name'] }}" required>
  </div>
  <div class="mb-3">
  <label>Department ID</label>
  <input type="number" name="department_id" class="form-control" required>
</div>
@php
  $departments = Http::get('http://127.0.0.1:8000/api/departments')->json();
@endphp

<div class="mb-3">
  <label>Department</label>
  <select name="department_id" class="form-control" required>
    <option value="">-- Select Department --</option>
    @foreach($departments as $dep)
      <option value="{{ $dep['id'] }}" 
        {{ isset($employee) && $employee['department_id'] == $dep['id'] ? 'selected' : '' }}>
        {{ $dep['name'] }}
      </option>
    @endforeach
  </select>
</div>

  <button class="btn btn-warning">Update</button>
  <a href="{{ route('departments.web.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
