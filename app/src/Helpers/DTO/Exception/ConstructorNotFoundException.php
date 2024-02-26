<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Helpers\DTO\Exception;

class ConstructorNotFoundException extends \Exception
{
    public function __construct(
        string $className,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $message = "Constructor for '$className' not found.";
        parent::__construct($message, $code, $previous);
    }
}
