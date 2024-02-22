<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Socket\Server;

use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketReceiveException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketListenException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketBindException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketAcceptException;
use Kiryao\Sockchat\Socket\Abstract\Socket as AbstractSocket;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketCreateException;
use Kiryao\Sockchat\Config\Exception\SocketConstantNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyIsEmptyException;

/**
 * @throws ErrorSocketBindException
 * @throws ErrorSocketListenException
 * @throws ErrorSocketAcceptException
 * @throws ErrorSocketReceiveException
 */
class Socket extends AbstractSocket
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ErrorSocketCreateException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function create(): self
    {
        $this->deletePreviousSocket();
        parent::create();

        return $this;
    }

    /**
     * @throws ConfigKeyIsEmptyException
     * @throws ConfigKeyNotFoundException
     * @throws ErrorSocketBindException
     * @throws SocketConstantNotFoundException
     */
    public function bind(): self
    {
        $result = socket_bind(
            $this->socket,
            $this->config->getPath(),
            $this->config->getPort()
        );

        if ($result === false) {
            throw new ErrorSocketBindException('Failed to bind socket: ' . $this->getError());
        }

        echo 'Socket bound successfully.' . PHP_EOL;

        return $this;
    }

    /**
     * @throws ConfigKeyIsEmptyException
     * @throws ConfigKeyNotFoundException
     * @throws ErrorSocketListenException
     * @throws SocketConstantNotFoundException
     */
    public function listen(): self
    {
        $result = socket_listen(
            $this->socket,
            $this->config->getBacklog()
        );

        if ($result === false) {
            throw new ErrorSocketListenException('Failed to listen socket: ' . $this->getError());
        }

        echo 'Socket listening successfully.' . PHP_EOL;

        return $this;
    }

    /**
     * @throws ErrorSocketAcceptException
     */
    public function accept(): self
    {
        $socket = socket_accept($this->socket);

        if ($socket === false) {
            throw new ErrorSocketAcceptException('Failed to accept socket: ' . $this->getError());
        }

        $this->socket = $socket;

        echo 'Client accepted successfully.' . PHP_EOL;

        return $this;
    }

    /**
     * @throws ConfigKeyIsEmptyException
     * @throws ConfigKeyNotFoundException
     * @throws SocketConstantNotFoundException
     */
    private function deletePreviousSocket(): void
    {
        if (file_exists($this->config->getPath())) {
            unlink($this->config->getPath());

            echo 'The previous socket deleted successfully.' . PHP_EOL;
        }
    }
}
