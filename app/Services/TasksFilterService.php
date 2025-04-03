<?php

namespace App\Services;

use App\DTOs\TasksFilterDto;
use App\Contracts\TasksFilter;
use Illuminate\Database\Eloquent\Builder;

class TasksFilterService implements TasksFilter
{
    public function filter(Builder &$query, TasksFilterDto $dto): void
    {
        $query->where(function ($query) use ($dto) {
            if ($dto->search) {
                $query->where('title', 'like', '%' . $dto->search . '%')
                    ->orWhere('content', 'like', '%' . $dto->search . '%');
            }
        });
        if ($dto->level) {
            $query->where('level', $dto->level);
        }
        if (!empty($dto->tags)) {
            $query->whereHas('tags', function ($query) use ($dto) {
                $query->whereIn('name', $dto->tags);
            });
        }

    }

}
