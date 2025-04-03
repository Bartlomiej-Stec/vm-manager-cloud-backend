<?php

namespace App\Http\Requests\Auth;

use App\DTOs\UserRegisterDto;
use App\Http\Requests\ApplicationRequest;

class RegisterRequest extends ApplicationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],  
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function toDto(): UserRegisterDto    
    {
        return UserRegisterDto::fromRequest($this);
    }
}
