<?php

declare(strict_types=1);

namespace AShutov\Hw5;

use Exception;

class App
{
    private ?Server $server = null;
    private ?Client $client = null;
    /**
     * @throws Exception
     */
    public function run($arg)
    {
        $config = $this->readConfig(dirname(__DIR__) . '/config/config.ini');

        switch ($arg) {
            case 'server':
                $this->server = new Server(new Socket($config));
                break;
            case 'client':
                $this->client = new Client(new Socket($config));
                break;
            default:
                throw new Exception("Неверный аргумент. Выберите server или client" . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    public function getAnswer(): \Generator
    {
        if ($this->client !== null) {
            foreach ($this->client->start() as $answer) {
                yield $answer;
            }
        }

        if ($this->server !== null) {
            foreach ($this->server->start() as $answer) {
                yield $answer;
            }
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
