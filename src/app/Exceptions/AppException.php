<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    public static function wrongArgumentCount(int $count): self
    {
        return new self(sprintf('Wrong arguments count, expected [%s] arguments', $count));
    }
}
