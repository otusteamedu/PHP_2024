<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\App;

use Kiryao\Sockchat\Socket\Server;
use Kiryao\Sockchat\Socket\Client;
use Kiryao\Sockchat\Config\DTO\SocketPath;
use Kiryao\Sockchat\Config\DTO\Socket;
use Kiryao\Sockchat\Config\DTO\Chat;
use Kiryao\Sockchat\Chat\IO\IOManager;
use Kiryao\Sockchat\Chat\ServerChat;
use Kiryao\Sockchat\Chat\ClientChat;
use Kiryao\Sockchat\App\Exception\ArgumentMissingException;
use InvalidArgumentException;
use Exception;

class App
{
    public function __construct(
        private Socket\Config $socketConfig,
        private SocketPath\Config $socketPathConfig,
        private Chat\Config $chatConfig,
        private IOManager $ioManager
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws ArgumentMissingException
     */
    public function run(): void
    {
        $arg = $_SERVER['argv'][1];

        $argServerRun = $this->chatConfig->getServerRun();
        $argClientRun = $this->chatConfig->getClientRun();
        $chatExit = $this->chatConfig->getChatExit();

        if (empty($arg)) {
            throw new ArgumentMissingException($argServerRun, $argClientRun);
        }

        $chat = match ($arg) {
            $argServerRun => new ServerChat(
                new Server\Socket(
                    $this->socketConfig,
                    $this->socketPathConfig
                ),
                $this->ioManager,
                $chatExit
            ),
            $argClientRun => new ClientChat(
                new Client\Socket(
                    $this->socketConfig,
                    $this->socketPathConfig,
                ),
                $this->ioManager,
                $chatExit
            ),
            default => throw new InvalidArgumentException('Invalid argument. Please use ' . $argServerRun . ' or ' . $argClientRun),
        };

        $chat->run();
    }
}
