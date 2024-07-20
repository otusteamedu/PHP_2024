<?php

declare(strict_types=1);

namespace App\Infrastructure\Enum;

enum RequestMethodEnum: string
{
    case GET = 'GET';
    case POST = 'POST';

    public function getData(): array
    {
        return match($this) {
            self::GET => $_GET,
            self::POST => !empty($_POST) ? $_POST : (array) json_decode(file_get_contents("php://input")),
        };
    }
}
