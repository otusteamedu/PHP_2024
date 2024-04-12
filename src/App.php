<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Actions\DeleteHall;
use Alogachev\Homework\Actions\GetAllHalls;
use Alogachev\Homework\Actions\CreateHall;
use Alogachev\Homework\Actions\GetHallById;
use Alogachev\Homework\Actions\UpdateHall;
use Alogachev\Homework\DataMapper\Entity\Hall;
use Alogachev\Homework\DataMapper\IdentityMap\HallIdentityMap;
use Alogachev\Homework\DataMapper\Mapper\HallMapper;
use Alogachev\Homework\Exception\EmptyActionNameException;
use Dotenv\Dotenv;
use PDO;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use DI\Container;
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
            $actionNameSpace = 'Alogachev\\Homework\\Actions\\';
            $service = $container->get($actionNameSpace . ucfirst($args['action']));

            call_user_func_array($service, [$args]);
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
        // postgres data
        $host = $_ENV['POSTGRES_DB_HOST'] ?? null;
        $db   = $_ENV['POSTGRES_DB_NAME'] ?? null;
        $dbPort = $_ENV['POSTGRES_PORT'] ?? null;
        $user = $_ENV['POSTGRES_USER'] ?? null;
        $pass = $_ENV['POSTGRES_PASSWORD'] ?? null;
        $dsn = "pgsql:host=$host;port=$dbPort;dbname=$db;user=$user;password=$pass";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO($dsn, $user, $pass, $options);

        return new Container([
            PDO::class => $pdo,
            HallMapper::class => create()->constructor(
                Hall::class,
                get(HallIdentityMap::class),
                get(PDO::class)
            ),
            HallIdentityMap::class => create()->constructor(),
            CreateHall::class => create()->constructor(get(HallMapper::class)),
            GetAllHalls::class => create()->constructor(get(HallMapper::class)),
            GetHallById::class => create()->constructor(get(HallMapper::class)),
            UpdateHall::class => create()->constructor(get(HallMapper::class)),
            DeleteHall::class => create()->constructor(get(HallMapper::class)),
        ]);
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
