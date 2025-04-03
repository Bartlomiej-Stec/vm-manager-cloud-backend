<?php

namespace App\Http\Requests;

use App\Exceptions\ApplicationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): never
    {
        $errors = $validator->errors();
        throw new ApplicationException(errors: $errors->toArray(), code: 422);
    }
}
