<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isSuperAdmin() === true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:positions,title'],
            'level' => ['required', 'integer', 'min:1'],
            'reports_to_id' => ['nullable', 'exists:positions,id'],
        ];
    }
}