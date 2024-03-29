<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands;

use Elastic\Elasticsearch\Client;
use Psr\Container\ContainerInterface;
use RailMukhametshin\ConfigManager\ConfigManager;
use RailMukhametshin\Hw\Formatters\ConsoleOutputFormatter;
use RailMukhametshin\Hw\Repositories\Elastic\OtusShopRepository;
use RailMukhametshin\Hw\Repositories\EventSystem\EventRepositoryInterface;

abstract class AbstractCommand implements CommandInterface
{
    protected ConsoleOutputFormatter $formatter;
    protected ConfigManager $configManager;
    protected Client $elasticClient;
    protected OtusShopRepository $otusShopRepository;
    protected EventRepositoryInterface $eventRepository;
    protected array $argv;

    public function __construct(
        ConfigManager $configManager,
        ConsoleOutputFormatter $formatter,
        Client $elasticClient,
        OtusShopRepository $otusShopRepository,
        EventRepositoryInterface $eventRepository
    )
    {
        $this->formatter = $formatter;
        $this->configManager = $configManager;
        $this->argv = array_slice($_SERVER['argv'], 2);
        $this->elasticClient = $elasticClient;
        $this->otusShopRepository = $otusShopRepository;
        $this->eventRepository = $eventRepository;
    }
}
