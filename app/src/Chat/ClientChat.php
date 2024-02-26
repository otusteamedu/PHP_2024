<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Chat;

use Kiryao\Sockchat\Socket\Client\Exception\ErrorSocketConnectException;
use Kiryao\Sockchat\Socket\Client;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketWriteException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketReadException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketCreateException;
use Kiryao\Sockchat\Chat\Std\StdManager;

class ClientChat implements ChatInterface
{
    public function __construct(
        private Client\Socket $socket,
        private StdManager $stdManager,
        private string $chatExit
    ) {
    }

    /**
     * @throws ErrorSocketConnectException
     * @throws ErrorSocketCreateException
     * @throws ErrorSocketReadException
     * @throws ErrorSocketWriteException
     */
    public function run(): void
    {
        $this->stdManager->printMessage('The client is running.');
        $this->socket->create()->connect();

        while (true) {
            $outputMessage = $this->stdManager->readLine("Enter any message (or '$this->chatExit' to exit) and press Enter: ");

            $this->socket->write($outputMessage);

            if ($outputMessage === $this->chatExit) {
                break;
            }

            $inputMessage = $this->socket->readMessage();
            $this->stdManager->printMessage($inputMessage);
        }

        $this->socket->close();
        $this->stdManager->printMessage('The client is stopped.');
    }
}
