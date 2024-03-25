<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands;

use DI\Container;
use Elastic\Elasticsearch\Client;
use RailMukhametshin\ConfigManager\ConfigManager;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;

abstract class AbstractCommand implements CommandInterface
{
    protected ConsoleOutputFormatter $formatter;
    protected ConfigManager $configManager;
    protected Client $elasticClient;
    protected Container $container;
    protected array $argv;

    public function __construct(ConfigManager $configManager, Container $container)
    {
        $this->formatter = $container->get(ConsoleOutputFormatter::class);
        $this->configManager = $configManager;
        $this->argv = array_slice($_SERVER['argv'], 2);
        $this->elasticClient = $container->get(Client::class);
        $this->container = $container;
    }
}
