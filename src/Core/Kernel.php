<?php

namespace KRudenko\Otus\Core;

use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Elastic\Elasticsearch\Client;
use KRudenko\Otus\Service\Elastic\ElasticClient;
use KRudenko\Otus\Service\Elastic\ElasticService;
use KRudenko\Otus\Service\MySql\MysqlService;
use KRudenko\Otus\Service\SearchServiceInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Finder\Finder;

readonly class Kernel
{
    private Container $container;
    private Application $console;

    public function __construct()
    {
        $this->boot();
    }

    public function handleCommand(array $argv): void
    {
        $this->console->run();
    }

    private function boot(): void
    {
        $this->loadEnvironment();
        $this->buildContainer();
        $this->initConsole();
    }

    private function loadEnvironment(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
        $dotenv->required(['APP_ENV']);
    }

    private function buildContainer(): void
    {
        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);

        $builder->addDefinitions([
            Client::class => fn() => ElasticClient::getClient(),
            SearchServiceInterface::class => function (Container $c) {
                return $c->get(match ($_ENV['SEARCH_ENGINE']) {
                    'mysql' => MysqlService::class,
                    default => ElasticService::class,
                });
            },
        ]);

        if ($_ENV['APP_ENV'] === 'prod') {
            $builder->enableCompilation(dirname(__DIR__, 2) . '/var/cache');
            $builder->writeProxiesToFile(true, dirname(__DIR__, 2) . '/var/proxies');
        }

        $this->container = $builder->build();
    }

    private function initConsole(): void
    {
        $this->console = new Application('Otus', '1.0');

        foreach ($this->findCommands(dirname(__DIR__) . '/Command') as $commandClass) {
            $this->console->add($this->container->get($commandClass));
        }
    }

    private function findCommands(string $directory): array
    {
        $finder = new Finder();
        $finder->files()->in($directory)->name('*Command.php');

        $commands = [];
        foreach ($finder as $file) {
            $className = 'KRudenko\\Otus\\Command\\' . $file->getBasename('.php');
            if (is_subclass_of($className, Command::class)) {
                $commands[] = $className;
            }
        }

        return $commands;
    }
}
