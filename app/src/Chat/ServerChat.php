<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Chat;

use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketListenException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketBindException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketAcceptException;
use Kiryao\Sockchat\Socket\Server;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketWriteException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketReadException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketCreateException;
use Kiryao\Sockchat\Chat\Std\StdManager;

class ServerChat implements ChatInterface
{
    public function __construct(
        private Server\Socket $socket,
        private StdManager $stdManager,
        private string $chatExit
    ) {
    }

    /**
     * @throws ErrorSocketAcceptException
     * @throws ErrorSocketBindException
     * @throws ErrorSocketCreateException
     * @throws ErrorSocketListenException
     * @throws ErrorSocketWriteException
     * @throws ErrorSocketReadException
     */
    public function run(): void
    {
        $this->stdManager->printMessage('The server is running.');
        $this->socket->create()->bind()->listen()->accept();
        $this->stdManager->printMessage('The client has successfully connected.');

        while (true) {
            $inputMessage = $this->socket->readMessage();

            if ($inputMessage === $this->chatExit) {
                break;
            }

            $this->stdManager->printMessage('The client sent a message: ' . $inputMessage);

            $this->socket->write(sprintf('Server received number of bytes: %s bytes.', mb_strlen($inputMessage)));
        }

        $this->socket->close();
        $this->stdManager->printMessage('The server is stopped.');
    }
}
