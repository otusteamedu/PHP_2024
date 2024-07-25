<?php

namespace App\Http\Exceptions;

use Exception;

/**
 * Custom http exception for bad request.
 */
class BadRequestHttpException extends HttpException
{
    /**
     * @param string $message
     */
    public function __construct(string $message = "")
    {
        parent::__construct($message, 400);
    }
}
