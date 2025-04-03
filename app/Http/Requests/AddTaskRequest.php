<?php

namespace App\Http\Requests;

use App\DTOs\AddTaskDto;
use App\Enums\TaskLevel;
use Illuminate\Validation\Rules\Enum;

class AddTaskRequest extends ApplicationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
            'level' => ['required', 'string', new Enum(TaskLevel::class)],
            'input' => ['nullable', 'string', 'max:1000'],
            'code' => ['required', 'string', 'max:10000'],
            'tags' => ['nullable', 'array', 'max:10'],
            'tags.*' => ['string', 'max:100'],
        ];
    }

    public function toDto(): AddTaskDto
    {
        return AddTaskDto::fromRequest($this);
    }
}
