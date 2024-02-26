<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Helpers\DTO\Exception;

class ClassNotImplementException extends \Exception
{
    public function __construct(
        string $subclass,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $message = "Class must implement '$subclass'.";
        parent::__construct($message, $code, $previous);
    }
}
