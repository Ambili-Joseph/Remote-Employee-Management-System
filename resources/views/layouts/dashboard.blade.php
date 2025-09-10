<!DOCTYPE html>
<html>
<head>
  <title>Remote Employee Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { display: flex; min-height: 100vh; }
    .sidebar { width: 220px; background: #2c3e50; color: #fff; padding: 20px; }
    .sidebar a { color: #ecf0f1; display: block; padding: 10px; text-decoration: none; border-radius: 5px; }
    .sidebar a:hover { background: #34495e; }
    .content { flex: 1; padding: 20px; background: #f9f9f9; }
  </style>
</head>
<body>
  <div class="sidebar">
    <h4>Admin Panel</h4>
    <a href="{{ route('employees.web.index') }}">👨‍💼 Employees</a>
    <a href="{{ route('departments.web.index') }}">🏢 Departments</a>
  </div>
  <div class="content">
    @yield('content')
  </div>
</body>
</html>
