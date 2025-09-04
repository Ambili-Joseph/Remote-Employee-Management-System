<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('employee')?->id ?? null;

        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:employees,email,' . $id,
            'department_id' => 'required|exists:departments,id',
            'salary'        => 'required|numeric|min:0.01',
            'joining_date'  => 'required|date',
        ];
    }
}
