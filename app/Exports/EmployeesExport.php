<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    protected $deptName;
    public function __construct(?string $deptName = null) { $this->deptName = $deptName; }

    public function collection()
    {
        $q = Employee::with('department');
        if ($this->deptName) {
            $name = $this->deptName;
            $q->whereHas('department', fn($qq) => $qq->where('name', $name));
        }

        return $q->get()->map(fn($e) => [
            'ID'           => $e->id,
            'Name'         => $e->name,
            'Email'        => $e->email,
            'Department'   => optional($e->department)->name,
            'Salary'       => $e->salary,
            'Joining Date' => $e->joining_date?->toDateString(),
        ]);
    }

    public function headings(): array
    {
        return ['ID','Name','Email','Department','Salary','Joining Date'];
    }
}
