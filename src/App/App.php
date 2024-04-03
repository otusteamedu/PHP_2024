<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\App;

use Elastic\Elasticsearch\Client;
use DI\Container;
use Exception;
use RailMukhametshin\Hw\Commands\Elastic\OtusShopImportCommand;
use RailMukhametshin\Hw\Commands\Elastic\OtusShopRemoveIndexCommand;
use RailMukhametshin\Hw\Commands\Elastic\OtusShopSearchCommand;
use RailMukhametshin\Hw\Commands\EventSystem\AddEventCommand;
use RailMukhametshin\Hw\Commands\EventSystem\RemoveAllEventCommand;
use RailMukhametshin\Hw\Commands\EventSystem\SearchEventCommand;
use RailMukhametshin\Hw\Commands\StartSocketClientCommand;
use RailMukhametshin\Hw\Commands\StartSocketServerCommand;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;
use RailMukhametshin\Hw\Managers\ConfigManager;
use RailMukhametshin\Hw\Repositories\Elastic\OtusShopRepository;
use RailMukhametshin\Hw\Repositories\EventSystem\EventRepositoryInterface;

class App
{
    private array $argv;

    private array $commands = [
        'server' => StartSocketServerCommand::class,
        'client' => StartSocketClientCommand::class,
        'otus-shop-import' => OtusShopImportCommand::class,
        'otus-shop-search' => OtusShopSearchCommand::class,
        'otus-shop-remove' => OtusShopRemoveIndexCommand::class,
        'event-system:add' => AddEventCommand::class,
        'event-system:search' => SearchEventCommand::class,
        'event-system:remove-all' => RemoveAllEventCommand::class
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

        $dirConfigs = __DIR__ . "/../Configs/";
        $files = scandir($dirConfigs);
        foreach ($files as $file){
            if (preg_match('/\.(php)/', $file)) {
                $configManager->load($dirConfigs . $file);
            }
        }

        $container = new Container($configManager->getAll());
        $formatter = $container->get(ConsoleOutputFormatter::class);

        try {
            (new $commandClass(
                $configManager,
                $formatter,
                $container->get(Client::class),
                $container->get(OtusShopRepository::class),
                $container->get(EventRepositoryInterface::class)
            ))->execute();
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
