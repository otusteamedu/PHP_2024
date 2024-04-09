<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Exception\EmptyActionNameException;
use Dotenv\Dotenv;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use DI\Container;
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
            $args = $this->resolveArgs();

//            call_user_func_array([$service, $args['action']], [$args]);
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

    private function resolveDI(): ContainerInterface
    {
//        $host = $_ENV['REDIS_HOST'] ?? null;
//        $port = $_ENV['REDIS_PORT'] ?? null;
//
//        $redis = new Redis();
//        $redis->connect($host, (int)$port);;
//
//        return new Container([
//            Redis::class => $redis,
//            RedisEventRepository::class => create()->constructor(
//                get(Redis::class)
//            ),
//            EventSourcingService::class => create()->constructor(
//                get(RedisEventRepository::class)
//            )
//        ]);

        return new Container();
    }

    private function resolveArgs(): array
    {
        $args = $_SERVER['argv'];
        $resolved = [];
        foreach ($args as $key => $arg) {
            if (str_starts_with($arg, '--')) {
                $argValue = $args[$key + 1];
                // Для аргументов массивов
                if (str_starts_with($argValue, '[') && str_ends_with($argValue, ']')) {
                    $argValue = explode(
                        ' ',
                        substr($argValue, 1, strlen($argValue) - 2)
                    );
                }

                $resolved[substr($arg, 2)] = $argValue;
            }
        }

        if (!isset($resolved['action'])) {
            throw new EmptyActionNameException();
        }

        return $resolved;
    }
}
