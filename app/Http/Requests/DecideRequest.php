<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DecideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'decision_reason' => ['required', 'string', 'max:2000'],
        ];
    }
}