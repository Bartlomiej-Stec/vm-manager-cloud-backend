<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;


class UpdateUserPasswordRequest extends ApplicationRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        if ($user === null) {
            return false;
        }
        return Hash::check($this->old_password ?? '', $user->password);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
