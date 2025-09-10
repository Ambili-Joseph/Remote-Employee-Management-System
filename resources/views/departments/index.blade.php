@extends('layouts.dashboard')

@section('content')
<h2>Departments</h2>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('departments.web.create') }}" class="btn btn-success mb-3">+ Add Department</a>

<table class="table table-bordered">
  <thead>
    <tr><th>ID</th><th>Name</th><th>Action</th></tr>
  </thead>
  <tbody>
    @foreach($departments as $dep)
    <tr>
      <td>{{ $dep['id'] }}</td>
      <td>{{ $dep['name'] }}</td>
      <td>
        <a href="{{ route('departments.web.edit', $dep['id']) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('departments.web.destroy', $dep['id']) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
