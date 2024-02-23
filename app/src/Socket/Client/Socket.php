<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Socket\Client;

use Kiryao\Sockchat\Socket\Client\Exception\ErrorSocketConnectException;
use Kiryao\Sockchat\Socket\Abstract\Socket as AbstractSocket;
use Kiryao\Sockchat\Config\Exception\SocketConstantNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyIsEmptyException;

class Socket extends AbstractSocket
{
    /**
     * @throws ConfigKeyNotFoundException
     * @throws ErrorSocketConnectException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function connect(): self
    {
        $result = socket_connect(
            $this->socket,
            $this->config->getPath(),
            $this->config->getPort()
        );

        if ($result === false) {
            throw new ErrorSocketConnectException('Failed to connect socket: ' . $this->getError());
        }

        return $this;
    }

    public function waitInputMessage(): string
    {
        $message = '';
        while (empty($message)) {
            $input = readline('Enter any message (or "/exit" to exit) and press Enter: ');
            $message = trim($input);
        }
        return $message;
    }
}
