<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionChangeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'new_position_id' => ['required', 'exists:positions,id'],
            'reason' => ['required', 'string', 'max:2000'],
        ];
    }
}
