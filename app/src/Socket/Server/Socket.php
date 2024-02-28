<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Socket\Server;

use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketListenException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketBindException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketAcceptException;
use Kiryao\Sockchat\Socket\Abstract\AbstractSocket;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketCreateException;

class Socket extends AbstractSocket
{
    /**
     * @throws ErrorSocketCreateException
     */
    public function create(): self
    {
        $this->deletePreviousSocket();
        parent::create();

        return $this;
    }

    /**
     * @throws ErrorSocketBindException
     */
    public function bind(): self
    {
        $result = socket_bind(
            $this->socket,
            $this->socketPathConfig->getPath(),
            $this->socketConfig->getPort()
        );

        if ($result === false) {
            throw new ErrorSocketBindException($this->getError());
        }

        return $this;
    }

    /**
     * @throws ErrorSocketListenException
     */
    public function listen(): self
    {
        $result = socket_listen(
            $this->socket,
            $this->socketConfig->getBacklog()
        );

        if ($result === false) {
            throw new ErrorSocketListenException($this->getError());
        }

        return $this;
    }

    /**
     * @throws ErrorSocketAcceptException
     */
    public function accept(): self
    {
        $socket = socket_accept($this->socket);

        if ($socket === false) {
            throw new ErrorSocketAcceptException($this->getError());
        }

        $this->socket = $socket;

        return $this;
    }

    private function deletePreviousSocket(): void
    {
        $config = $this->socketPathConfig->getPath();

        if (file_exists($config)) {
            unlink($config);
        }
    }
}
