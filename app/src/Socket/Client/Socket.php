<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Socket\Client;

use Kiryao\Sockchat\Socket\Client\Exception\ErrorSocketConnectException;
use Kiryao\Sockchat\Socket\Abstract\AbstractSocket;

class Socket extends AbstractSocket
{
    /**
     * @throws ErrorSocketConnectException
     */
    public function connect(): self
    {
        $result = socket_connect(
            $this->socket,
            $this->socketPathConfig->getPath(),
            $this->socketConfig->getPort()
        );

        if ($result === false) {
            throw new ErrorSocketConnectException($this->getError());
        }

        return $this;
    }
}
