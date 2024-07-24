<?php

namespace App\Http\Exceptions;

/**
 * Not found http exception.
 */
class NotFoundHttpException extends HttpException
{
    /**
     * @param string $message
     */
    public function __construct(string $message = "")
    {
        parent::__construct($message, 404);
    }
}
