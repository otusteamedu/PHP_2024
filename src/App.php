<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\EventSourcing\EventSourcingService;
use Alogachev\Homework\EventSourcing\RedisEventRepository;
use Alogachev\Homework\Exception\EmptyActionNameException;
use Dotenv\Dotenv;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use DI\Container;
use Redis;
use RedisException;
use RuntimeException;

use function DI\create;
use function DI\get;

final class App
{
    public function run(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        try {
            $container = $this->resolveDI();
            $service = $container->get(EventSourcingService::class);
            $args = $this->resolveArgs();
        } catch (RedisException $exception) {
            throw new RuntimeException(
                "Ошибка подключения к Redis: " . $exception->getMessage(),
                0,
                $exception
            );
        } catch (ContainerExceptionInterface $exception) {
            throw new RuntimeException(
                "Ошибка подключения зависимостей: " . $exception->getMessage(),
                0,
                $exception
            );
        }
    }

    /**
     * @throws RedisException
     */
    private function resolveDI(): ContainerInterface
    {
        $host = $_ENV['REDIS_HOST'] ?? null;
        $port = $_ENV['REDIS_PORT'] ?? null;

        $redis = new Redis();
        $redis->connect($host, (int)$port);;

        return new Container([
            Redis::class => $redis,
            RedisEventRepository::class => create()->constructor(
                get(Redis::class)
            ),
            EventSourcingService::class => create()->constructor(
                get(RedisEventRepository::class)
            )
        ]);
    }

    private function resolveArgs(): array
    {
        $args = $_SERVER['argv'];
        $resolved = [];
        foreach ($args as $key => $arg) {
            if (str_starts_with($arg, '--')) {
                $resolved[substr($arg, 2)] = $args[$key + 1];
            }
        }

        if (!isset($resolved['action'])) {
            throw new EmptyActionNameException();
        }

        return $resolved;
    }
}
