<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Response\Elasticsearch;
use RailMukhametshin\ConfigManager\ConfigManager;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;

abstract class AbstractCommand implements CommandInterface
{
    protected ConsoleOutputFormatter $formatter;
    protected ConfigManager $configManager;
    protected Client $elasticClient;
    protected array $argv;

    public function __construct(ConfigManager $configManager, Client $elasticClient, ConsoleOutputFormatter $formatter)
    {
        $this->formatter = $formatter;
        $this->configManager = $configManager;
        $this->argv = array_slice($_SERVER['argv'], 2);
        $this->elasticClient = $elasticClient;
    }
}
