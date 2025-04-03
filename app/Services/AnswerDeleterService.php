<?php

namespace App\Services;

use App\Models\Result;
use App\Contracts\AnswerDeleter;

class AnswerDeleterService implements AnswerDeleter 
{
	public function delete(Result $result): void 
    {
        $result->delete();
    }

}
