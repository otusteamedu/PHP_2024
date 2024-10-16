<?php

declare(strict_types=1);

namespace Naimushina\ElasticSearch;

use Exception;
use Naimushina\ElasticSearch\Commands\ClearStorageCommand;
use Naimushina\ElasticSearch\Commands\SearchInStorageCommand;
use Naimushina\ElasticSearch\Commands\SeedFromFileCommand;
use Naimushina\ElasticSearch\Storages\ElasticSearchStorage;
use Symfony\Component\Console\Application;


class App
{
    /**
     * Запуск приложения
     * @throws Exception
     */
    public function run(): int
    {
        $configs = new ConfigService();

        $storage = new ElasticSearchStorage(...$configs->getConfigByName('elastic'));
        $commandName = $_SERVER['argv'][1] ?? null;
        $consoleApp = new Application();
         match ($commandName) {
            'seed' => $consoleApp->add(new SeedFromFileCommand($storage)),
            'clear' => $consoleApp->add(new ClearStorageCommand($storage)),
            'search' => $consoleApp->add(new SearchInStorageCommand($storage)),

            default => throw new Exception('Unknown command "' . $commandName . '"')
        };
         return $consoleApp->run();
    }
}
