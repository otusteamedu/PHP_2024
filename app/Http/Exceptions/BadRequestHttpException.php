<?php

namespace App\Http\Exceptions;

use Exception;

class BadRequestHttpException extends HttpException
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 400);
    }
}