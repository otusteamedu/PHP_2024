<?php

namespace App\Http\Exceptions;

use Exception;
use Throwable;

class BadRequestException extends Exception
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 400);
    }
}