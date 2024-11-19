<?php

declare(strict_types=1);

namespace App\Domain\Service;

use Dotenv\Dotenv;

class ConfigService
{
    public static function get(string $key): string
    {
        $dotenv = Dotenv::createArrayBacked('/app', '.env');

        return  $dotenv->load()[$key];
    }

    public static function getConfigureForTesting(string $key): string
    {
        $dotenv = Dotenv::createArrayBacked('/app', '.env.test');

        return  $dotenv->load()[$key];
    }
}
