<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands;

use RailMukhametshin\ConfigManager\ConfigManager;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;

abstract class AbstractCommand implements CommandInterface
{
    protected ConsoleOutputFormatter $formatter;
    private ConfigManager $configManager;

    public function __construct(ConfigManager $configManager)
    {
        $this->formatter = new ConsoleOutputFormatter();
        $this->configManager = $configManager;
    }

    protected function getConfigManager(): ConfigManager
    {
        return $this->configManager;
    }
}
