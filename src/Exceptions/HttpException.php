<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Exceptions;

use Exception;

class HttpException extends Exception
{
    private int $status;

    public function __construct(string $message, int $status = 400)
    {
        $this->status = $status;
        parent::__construct($message);
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
