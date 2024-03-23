<?php

declare(strict_types=1);

use DI\Container;
use Elastic\Elasticsearch\Client as ElasticClient;
use Elastic\Elasticsearch\ClientBuilder;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;
use RailMukhametshin\Hw\Repositories\EventSystem\EventRepositoryInterface;
use RailMukhametshin\Hw\Repositories\EventSystem\RedisEventRepository;

return [
    Redis::class => function (Container $container) {
        $host = $container->get('redis_host');
        $port = $container->get('redis_port');
        $redis = new Redis();
        $redis->connect($host, $port);
        return $redis;
    },
    EventRepositoryInterface::class => function (Container $container) {
        return new RedisEventRepository($container->get(Redis::class));
    },
    ConsoleOutputFormatter::class => fn() => new ConsoleOutputFormatter(),
    ElasticClient::class => function (Container $container) {
        $host = sprintf(
            '%s:%s',
            $container->get('elastic_host'),
            $container->get('elastic_port')
        );

        $password = $container->get('elastic_password');
        $keyPath = $container->get('elastic_key_path');

        return ClientBuilder::create()
            ->setHosts([$host])
            ->setBasicAuthentication('elastic', $password)
            ->setCABundle(__DIR__ . "/../../" . $keyPath)
            ->build();
    }
];
