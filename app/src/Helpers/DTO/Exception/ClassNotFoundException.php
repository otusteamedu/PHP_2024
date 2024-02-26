<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Helpers\DTO\Exception;

class ClassNotFoundException extends \Exception
{
    public function __construct(
        string $className,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $message = "Class '$className' not found.";
        parent::__construct($message, $code, $previous);
    }
}
