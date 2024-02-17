<?php

declare(strict_types=1);

namespace Rmulyukov\Hw4;

final class Response
{
    private string $message;
    public function __construct(bool $success)
    {
        if ($success) {
            $this->initSuccess();
        } else {
            $this->initError();
        }
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    private function initSuccess(): void
    {
        header("HTTP/1.1 200 OK");
        $this->message = 'OK';
    }

    private function initError(): void
    {
        header("HTTP/1.1 400 Bad request");
        $this->message = 'Incorrect string';
    }
}
