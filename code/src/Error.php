<?php

declare(strict_types=1);

namespace Otus\Chat;

use Exception;

class Error
{
    public function __construct(string $message)
    {
        if ($message) {
            throw new Exception($message, 1);
        }
    }
}
