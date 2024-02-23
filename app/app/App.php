<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5;

use Exception;
use Rmulyukov\Hw5\Chat\Client;
use Rmulyukov\Hw5\Chat\Server;
use Rmulyukov\Hw5\Config\Config;

final readonly class App
{
    private Config $configs;
    /**
     * @var mixed|null
     */
    private string $chatType;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $chatType = $_SERVER['argv'][1] ?? '';
        if (!in_array($chatType, ['server', 'client'], true)) {
            throw new Exception('Argument 1 must be one of "server, client"');
        }
        $this->chatType = $chatType;
        $this->configs = new Config(__DIR__ . '/../config/config.php');
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $socketFile = $this->configs->getStoragePath() . '/' . $this->configs->getSocketFile();
        $chat = match ($this->chatType) {
            'server' => new Server($socketFile),
            'client' => new Client($socketFile)
        };

        $chat->run();
    }
}
