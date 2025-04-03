<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Contracts\MarkSetter;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SetTaskMarkRequest;

class SetAnswerMarkController extends Controller
{
    public function __construct(
        private MarkSetter $markSetter
    ) {

    }

    public function __invoke(Result $result, SetTaskMarkRequest $request): JsonResponse
    {
        $this->markSetter->setMark($result, $request->mark, $request->user()->id);
        return $this->success(['message' => 'Mark set successfully']);
    }
}
