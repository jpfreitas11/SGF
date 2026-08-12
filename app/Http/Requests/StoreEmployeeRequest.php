<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'document' => ['required', 'string', 'max:30', 'unique:employees,document'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'salary' => ['required', 'numeric', 'min:0'],
            'hired_at' => ['required', 'date'],
        ];
    }
}