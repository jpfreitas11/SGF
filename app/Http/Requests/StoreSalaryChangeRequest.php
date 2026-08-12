<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalaryChangeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'new_salary' => ['required', 'numeric', 'min:0'],
            'reason' => ['required', 'string', 'max:2000'],
        ];
    }
}