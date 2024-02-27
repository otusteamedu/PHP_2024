<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

use DI\Container;
use Dotenv\Dotenv;
use Exception;

use function DI\autowire;

class App
{
    private Container $container;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $config = new Config($_ENV['CONFIG_PATH']);

        $this->container = new Container([
            SocketManager::class => autowire()
                ->constructorParameter(
                    'socketPath',
                    $config->socketPath
                ),
            Config::class => $config,
        ]);
    }

    public function run(): void
    {
        $appType = $this->readAppType();

        $app = match ($appType) {
            'server' => $this->container->get(Server::class),
            'client' => $this->container->get(Client::class),
            default => throw new Exception("Wrong app type", 1),
        };

        $app->run();
    }

    private function readAppType(): string
    {
        if ($_SERVER['argc'] !== 2) {
            throw new Exception("Wrong arguments count", 1);
        }

        return strtolower(trim($_SERVER['argv'][1]));
    }
}
