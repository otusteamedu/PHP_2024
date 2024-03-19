<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\App;

use Elastic\Elasticsearch\ClientBuilder;
use Exception;
use RailMukhametshin\ConfigManager\ConfigManager;
use RailMukhametshin\Hw\Commands\Elastic\OtusShopImportCommand;
use RailMukhametshin\Hw\Commands\Elastic\OtusShopRemoveIndexCommand;
use RailMukhametshin\Hw\Commands\Elastic\OtusShopSearchCommand;
use RailMukhametshin\Hw\Commands\StartSocketClientCommand;
use RailMukhametshin\Hw\Commands\StartSocketServerCommand;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;

class App
{
    private array $argv;

    private array $commands = [
        'server' => StartSocketServerCommand::class,
        'client' => StartSocketClientCommand::class,
        'otus-shop-import' => OtusShopImportCommand::class,
        'otus-shop-search' => OtusShopSearchCommand::class,
        'otus-shop-remove' => OtusShopRemoveIndexCommand::class
    ];

    public function __construct()
    {
        $this->argv = $_SERVER['argv'];
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $commandClass = $this->commands[$this->getCommandName()] ?? null;

        if ($commandClass === null) {
            throw new Exception('Command not found!');
        }

        $configManager = new ConfigManager();
        $configManager->load(__DIR__ . "/../Configs/socket.php");
        $configManager->load(__DIR__ . "/../Configs/elastic.php");

        $host = sprintf(
            '%s:%s',
            $configManager->get('elastic_host'),
            $configManager->get('elastic_port')
        );

        $password = $configManager->get('elastic_password');
        $keyPath = $configManager->get('elastic_key_path');

        $elasticClient = ClientBuilder::create()
            ->setHosts([$host])
            ->setBasicAuthentication('elastic', $password)
            ->setCABundle(__DIR__ . "/../../" . $keyPath)
            ->build();

        $formatter = new ConsoleOutputFormatter();

        try{
            (new $commandClass($configManager, $elasticClient, $formatter))->execute();
        } catch (Exception $exception) {
            $formatter->output($exception->getMessage(), ConsoleOutputFormatter::COLOR_RED);
        }
    }

    private function getCommandName(): string
    {
        if (!isset($this->argv[1])) {
            throw new Exception('Command name is empty!');
        }

        return $this->argv[1];
    }
}
