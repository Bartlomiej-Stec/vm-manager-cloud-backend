<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\JsonResponse;
use App\Contracts\AnswerOutputAdder;
use App\Http\Requests\AddTaskOutputRequest;

class AddAnswerOutputController extends Controller
{
    public function __construct(
        private AnswerOutputAdder $answerOutputAdder
    ) {

    }

    public function __invoke(Result $result, AddTaskOutputRequest $request): JsonResponse
    {
        $this->answerOutputAdder->add($result, $request->output);
        return $this->success(['message' => 'Answer output added successfully']);
    }
}
