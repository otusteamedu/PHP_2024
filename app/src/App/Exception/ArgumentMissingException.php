<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\App\Exception;

class ArgumentMissingException extends \Exception
{
    public function __construct(
        string $argServerRun,
        string $argClientRun,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $message = "Argument missing. Please use '$argServerRun' or '$argClientRun'";
        parent::__construct($message, $code, $previous);
    }
}
