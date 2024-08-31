<?php

use Slim\App;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;

use App\Infrastructure\Manager\ConnectionManager;
use App\Infrastructure\Repository\PostgresRepository;
use App\Infrastructure\Repository\MemcacheRepository;
use App\Infrastructure\Repository\RedisRepository;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);

        // Register routes
        (require __DIR__ . '/routes.php')($app);

        // Register middleware
        (require __DIR__ . '/middleware.php')($app);

        return $app;
    },

    PostgresRepository::class => function (ContainerInterface $container) {
        [
            'host' => $host,
            'port' => $port,
            'db' => $database,
            'user' => $username,
            'password' => $password,
        ] = $container->get('settings')['database'];

        $dsnTemplate = 'pgsql:host=%s;port=%s;dbname=%s;';
        $dsn = sprintf($dsnTemplate, $host, $port, $database);

        return new PostgresRepository(new PDO(dsn: $dsn, username: $username, password: $password));
    },

    MemcacheRepository::class => function (ContainerInterface $container) {
        $memcache = new Memcache();
        $memcache->addServer('memcached');
        return new MemcacheRepository($memcache);
    },

    RedisRepository::class => function (ContainerInterface $container) {
        $redis = new Redis(['host' => 'redis']);
        return new RedisRepository($redis);
    },

    ConnectionManager::class => function (ContainerInterface $container) {
        return new ConnectionManager(
            postgres: $container->get(PostgresRepository::class),
            memcache: $container->get(MemcacheRepository::class),
            redis: $container->get(RedisRepository::class)
        );
    }
];
