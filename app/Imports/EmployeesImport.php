<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class EmployeesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    // Expected columns: name,email,department,salary,joining_date
    public function rules(): array
    {
        return [
            '*.name'          => 'required|string',
            '*.email'         => 'required|email|unique:employees,email',
            '*.department'    => 'required|string',
            '*.salary'        => 'required|numeric|min:0.01',
            '*.joining_date'  => 'required|date',
        ];
    }

    public function model(array $row)
    {
        $dept = Department::firstOrCreate(['name' => trim($row['department'])]);

        return new Employee([
            'name'          => $row['name'],
            'email'         => $row['email'],
            'department_id' => $dept->id,
            'salary'        => $row['salary'],
            'joining_date'  => \Carbon\Carbon::parse($row['joining_date'])->toDateString(),
        ]);
    }
}
