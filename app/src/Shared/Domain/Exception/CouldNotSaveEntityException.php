<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use RuntimeException;
use Throwable;

class CouldNotSaveEntityException extends RuntimeException
{
    public static function forEntity(string $name, ?Throwable $e = null): self
    {
        $message = sprintf('Could not save entity [%s]', $name);

        if ($e !== null) {
            $message .= ': ' . $e->getMessage();
        }

        return new self($message, $e?->getCode() ?? 0, $e);
    }
}
