<?php

declare(strict_types=1);

namespace App\Domain\Service;

use Dotenv\Dotenv;

class ConfigService
{
    public static function get(string $key): string
    {
        $dotenv = Dotenv::createArrayBacked('/app');

        return  $dotenv->load()[$key];
    }
}
