<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\App;

use Exception;
use RailMukhametshin\ConfigManager\ConfigManager;
use RailMukhametshin\Hw\Commands\StartSocketClientCommand;
use RailMukhametshin\Hw\Commands\StartSocketServerCommand;

class App
{
    private array $argv;

    private array $commands = [
        'server' => StartSocketServerCommand::class,
        'client' => StartSocketClientCommand::class
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

        (new $commandClass($configManager))->execute();
    }

    private function getCommandName(): string
    {
        if (!isset($this->argv[1])) {
            throw new Exception('Command name is empty!');
        }

        return $this->argv[1];
    }
}
