<?php

namespace App\Http\Requests;

use App\DTOs\AddResultDto;
use Illuminate\Foundation\Http\FormRequest;

class AddResultRequest extends ApplicationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:10000'],
        ];
    }

    public function toDto(): AddResultDto
    {
        return AddResultDto::fromRequest($this);
    }
}
