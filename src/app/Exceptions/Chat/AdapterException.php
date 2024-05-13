<?php

declare(strict_types=1);

namespace App\Exceptions\Chat;

use Exception;

class AdapterException extends Exception
{
    public static function unknownType(string $type): self
    {
        return new self(sprintf('Unknown adapter type [%s]', $type));
    }
}
