<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetTaskMarkRequest extends ApplicationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mark' => ['required', 'integer', 'min:0', 'max:5'],
        ];
    }
}
