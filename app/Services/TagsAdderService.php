<?php

namespace App\Services;

use App\Models\Tag;
use App\Contracts\TagsAdder;

class TagsAdderService implements TagsAdder
{
    public function add(array $tags, int $taskId): void
    {
        $results = [];
        foreach ($tags as $tag) {
            $results[] = [
                'name' => $tag,
                'task_id' => $taskId
            ];
        }
        Tag::where('task_id', $taskId)->delete();
        if(count($results) > 0){
            Tag::insert($results);
        }
    }

}
