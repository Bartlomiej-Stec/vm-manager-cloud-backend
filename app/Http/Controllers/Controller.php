<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function success(?array $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json(array_merge([
            'status' => 'success',
        ], $data), $statusCode);
    }
}
