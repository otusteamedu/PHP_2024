<?php

declare(strict_types=1);

namespace Otus\App\EmailChecker;

class Response
{
    public function success(string $message = null): void
    {
        http_response_code(200);
        echo $message ?? 'VALID';
    }

    public function error(string $message = null): void
    {
        http_response_code(400);
        echo $message ?? 'INVALID';
    }
}
