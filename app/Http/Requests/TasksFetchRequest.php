<?php

namespace App\Http\Requests;

use App\Enums\TaskLevel;
use App\DTOs\TasksFilterDto;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class TasksFetchRequest extends ApplicationRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tags' => ['nullable', 'array', 'max:10'],
            'tags.*' => ['string', 'max:100'],
            'level' => ['nullable', 'string', new Enum(TaskLevel::class)],
            'search' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function toDto(): TasksFilterDto
    {
        return TasksFilterDto::fromRequest($this);
    }
}
