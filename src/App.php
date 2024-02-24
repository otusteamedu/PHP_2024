<?php

declare(strict_types=1);

namespace AShutov\Hw5;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run($arg): void
    {
        $config = $this->readConfig(dirname(__DIR__) . '/config/config.ini');

        switch ($arg) {
            case 'server':
                $server = new Server(new Socket($config));
                $server->start();
                break;
            case 'client':
                $client = new Client(new Socket($config));
                $client->start();
                break;
            default:
                throw new Exception("Неверный аргумент. Выберите server или client" . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    private function readConfig(string $path): array
    {
        if (!file_exists($path)) {
            throw new Exception("Файл конфига не найден");
        }

        $config = parse_ini_file($path);

        if ($config === false) {
            throw new Exception("Неверно составлен файл конфига");
        }

        return $config;
    }
}
