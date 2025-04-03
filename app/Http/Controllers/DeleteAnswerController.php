<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Contracts\AnswerDeleter;
use Illuminate\Http\JsonResponse;

class DeleteAnswerController extends Controller
{
    public function __construct(
        private AnswerDeleter $answerDeleter
    ) {

    }

    public function __invoke(Result $result): JsonResponse
    {
        $this->answerDeleter->delete($result);
        return $this->success(['message' => 'Answer deleted successfully']);
    }
}
