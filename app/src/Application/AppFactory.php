<?php

declare(strict_types=1);

namespace Dw\OtusSocketChat\Application;

use Dw\OtusSocketChat\Client;
use Dw\OtusSocketChat\Config\ConfigIniReader;
use Dw\OtusSocketChat\Server;
use Exception;

class AppFactory
{
    /**
     * @throws Exception
     */
    public static function getApplication(string $type): ApplicationInterface
    {
        $configuration = new ConfigIniReader();

        $application =  match ($type) {
            'server' => new Server($configuration),
            'client' => new Client($configuration),
            default => null,
        };

        if (empty($application)) {
            throw new Exception('Некорректный идентификатор приложения');
        }

        return $application;
    }
}
