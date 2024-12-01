<?php

declare(strict_types=1);

namespace RShevtsov\Hw5;

class Response
{
    public function setError(string $message): void
    {
        echo $message;
    }

    public function setSuccess(string $message): void
    {
        echo $message;
    }
}