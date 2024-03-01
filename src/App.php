<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Exception\InvalidAppTypeException;
use Alogachev\Homework\Exception\WrongInputException;
use Alogachev\Homework\Interface\IRun;
use DI\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class App
{
    private const ALLOWED_APP_TYPES = [
        'client',
        'server',
    ];

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        $container = $this->resolveDI();
        $appType = $this->resolveAppType();
        /** @var IRun $app */
        $app = match ($appType) {
            'server' => $container->get(Server::class),
            'client' => $container->get(Client::class),
        };
//        $app = $container->get(ucfirst($appType));
        $app->run();

        echo "\nВсе хорошо. Работаем!";
    }

    private function resolveDI(): ContainerInterface
    {
        $config = Config::getInstance()->getConfig();
        var_dump($config);

        return new Container([
            '$socketPath' => $config['socket']['path'] ?? '',
            '$stopWord' => $config['socket']['stop_word'] ?? '',
        ]);
    }

    private function resolveAppType(): string
    {
        if ($_SERVER['argc'] !== 2) {
            throw new WrongInputException();
        }
        $appType = strtolower(trim($_SERVER['argv'][1]));

        if (!in_array($appType, self::ALLOWED_APP_TYPES)) {
            throw new InvalidAppTypeException($appType);
        }

        return $appType;
    }
}
