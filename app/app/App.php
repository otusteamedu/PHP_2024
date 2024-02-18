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
        $serverSocketFile = $this->configs->getString('serverFile', 'server.sock');
        if ($this->chatType === 'server') {
            (new Server($serverSocketFile))->run();
            return;
        }
        $clientSocketFile = $this->configs->getString('clientFile', 'client.sock');
        (new Client($clientSocketFile, $serverSocketFile))->run();
    }
}
