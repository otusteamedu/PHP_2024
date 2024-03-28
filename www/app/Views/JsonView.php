<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\Views;

class JsonView
{
    public static function render(array|object $obj): string
    {
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($obj);
    }
}
