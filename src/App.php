<?php

namespace Ahor\Hw5;

class App
{
    public Config $config;

    public function __construct(string $fileConfigName)
    {
        $this->config = new Config($fileConfigName);
    }

    public function run($arg): void
    {
        switch ($arg) {
            case 'server':
                $server = new Server($this->config);
                $server->start();

                break;
            case 'client':
                $client = new Client($this->config);
                $client->start();

                break;
            default:
                throw new \DomainException('Ошибка аргумента, server или client' . PHP_EOL);
        }
    }
}
