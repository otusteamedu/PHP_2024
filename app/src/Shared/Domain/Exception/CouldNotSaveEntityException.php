<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Exception;

class CouldNotSaveEntityException extends Exception
{
    public static function forEntity(string $name, ?Exception $e = null): self
    {
        $message = sprintf('Could not save entity [%s]', $name);

        if ($e !== null) {
            $message .= ': ' . $e->getMessage();
        }

        return new self($message, $e?->getCode() ?? 0, $e);
    }
}
