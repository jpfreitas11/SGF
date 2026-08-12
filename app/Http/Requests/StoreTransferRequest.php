<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'to_department_id' => ['required', 'exists:departments,id'],
            'reason' => ['required', 'string', 'max:2000'],
        ];
    }
}