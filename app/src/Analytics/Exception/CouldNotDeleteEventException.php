<?php

declare(strict_types=1);

namespace App\Analytics\Exception;

use Exception;

final class CouldNotDeleteEventException extends Exception
{
    public static function make(): self
    {
        $message = 'Could not delete event';

        return new self($message);
    }
}
