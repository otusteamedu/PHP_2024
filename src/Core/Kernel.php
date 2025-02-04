<?php

namespace KRudenko\Otus\Core;

use Dotenv\Dotenv;
use KRudenko\Otus\Service\EventSystem;
use KRudenko\Otus\Service\Storage\MemcachedStorage;
use KRudenko\Otus\Service\Storage\RedisStorage;

class Kernel
{
    public function __construct()
    {
        $this->boot();
    }

    public function handleCommand(): string
    {
        $storage = match ($_ENV['STORAGE'] ?? 'redis') {
            'memcached' => new MemcachedStorage(),
            default => new RedisStorage(),
        };
        $eventSystem = new EventSystem($storage);

        $command = $_SERVER['argv'][1] ?? null;

        switch ($command) {
            case 'add':
                $options = $this->getOpt();
                $id = $eventSystem->addEvent([
                    'priority' => (int)$options['priority'] ?? 0,
                    'conditions' => json_decode($options['conditions'] ?? '{}', true),
                    'event' => json_decode($options['event'] ?? '{}', true)
                ]);
                return "Event added with ID: $id\n";

            case 'clear':
                $eventSystem->clearEvents();
                return "All events cleared\n";

            case 'find':
                $options = $this->getOpt();
                $result = $eventSystem->findBestEvent(
                    json_decode($options['params'] ?? '{}', true)
                );
                return json_encode($result, JSON_PRETTY_PRINT) . "\n";

            default:
                return "Usage:\n"
                    . "php index.php add --priority=N --conditions='JSON' --event='JSON'\n"
                    . "php index.php find --params='JSON'\n"
                    . "php index.php clear\n";
        }
    }

    private function boot(): void
    {
        $this->loadEnvironment();
    }

    private function loadEnvironment(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
    }

    private function getOpt(): array
    {
        $options = array();
        foreach (array_slice($_SERVER["argv"], 2) as $arg) {
            if (preg_match('@--(.+)=(.+)@', $arg, $matches)) {
                $key = $matches[1];
                $value = $matches[2];
                $options[$key] = $value;
            } else if (preg_match("@-(.)(.)@", $arg, $matches)) {
                $key = $matches[1];
                $value = $matches[2];
                $options[$key] = $value;
            }
        }

        return $options;
    }
}
