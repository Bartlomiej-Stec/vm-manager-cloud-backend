<?php

namespace App\Services;

use App\Models\Result;
use App\Contracts\MarkSetter;
use App\Exceptions\SettingMarkNoAccessException;

class MarkSetterService implements MarkSetter
{
    public function setMark(Result $result, int $mark, int $userId): void
    {
        if ($result->task->created_by != $userId) {
            throw new SettingMarkNoAccessException('You cannot set mark for this answer', 403);
        }
        $result->update([
            'mark' => $mark
        ]);
    }

}
