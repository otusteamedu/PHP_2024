<?php

namespace App\Http\Exceptions;

use Exception;

class NotFoundHttpException extends HttpException
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 404);
    }
}