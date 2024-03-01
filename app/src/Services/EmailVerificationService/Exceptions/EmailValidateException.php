<?php

declare(strict_types=1);

namespace App\Services\EmailVerificationService\Exceptions;

use Throwable;

class EmailValidateException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
