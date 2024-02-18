<?php

declare(strict_types=1);

namespace Rmulyukov\Hw4;

final class Response
{
    private string $message;
    private string $header;

    public function __construct(bool $success)
    {
        if ($success) {
            $this->initSuccess();
        } else {
            $this->initError();
        }
    }

    public function send(): string
    {
        header($this->header);
        return $this->message;
    }

    private function initSuccess(): void
    {
        $this->header = 'HTTP/1.1 200 OK';
        $this->message = 'OK';
    }

    private function initError(): void
    {
        $this->header = 'HTTP/1.1 400 Bad request';
        $this->message = 'Incorrect string';
    }
}
