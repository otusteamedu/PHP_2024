<?php

declare(strict_types=1);

namespace App\Analytics\Exception;

use Exception;

final class CouldNotSaveEventException extends Exception
{
    public static function make(): self
    {
        $message = 'Could not save event';

        return new self($message);
    }
}
