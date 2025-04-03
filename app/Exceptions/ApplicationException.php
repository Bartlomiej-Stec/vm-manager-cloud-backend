<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;

class ApplicationException extends Exception
{
    /**
     * Constructor to initialize error messages.
     *
     * @param  array  $errors
     * @param  string  $message
     * @param  int  $code
     */
    public function __construct(string $message = 'Validation failed', int $code = 400, protected array $errors = [])
    {
        parent::__construct($message, $code);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->message,
            'errors' => $this->errors,
        ], $this->code);
    }
}
