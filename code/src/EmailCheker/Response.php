<?php

declare(strict_types=1);

namespace Otus\App\EmailCheker;

class Response
{
    public function success(string $message = null)
    {
        http_response_code(200);
        echo $message ?? 'VALID';
    }

    public function error(string $message = null)
    {
        http_response_code(400);
        echo $message ?? 'INVALID';
    }
}
