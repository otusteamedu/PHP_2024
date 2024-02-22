<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Socket\Abstract;

use Socket as BaseSocket;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketReceiveException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketWriteException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketReadException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketCreateException;
use Kiryao\Sockchat\Config\SocketConfig;
use Kiryao\Sockchat\Config\Exception\SocketConstantNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyIsEmptyException;
use Kiryao\Sockchat\Config\ConfigProvider;

/**
 * @throws ConfigNotFoundException
 * @throws ErrorSocketCreateException
 * @throws ErrorSocketReadException
 * @throws ErrorSocketWriteException
 */
abstract class Socket
{
    protected BaseSocket $socket;
    protected SocketConfig $config;

    /**
     * @throws ConfigNotFoundException
     */
    protected function __construct()
    {
        $configSocket = (new ConfigProvider())->load('socket');
        $this->config = new SocketConfig($configSocket);
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ErrorSocketCreateException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function create(): self
    {
        $socket = socket_create(
            $this->config->getDomain(),
            $this->config->getType(),
            $this->config->getProtocol()
        );

        if ($socket === false) {
            throw new ErrorSocketCreateException('Failed to create socket: ' . $this->getError());
        }

        $this->socket = $socket;
        echo 'Socket created successfully.' . PHP_EOL;

        return $this;
    }

    public function close(): self
    {
        socket_close($this->socket);
        echo 'Socket closed successfully.' . PHP_EOL;

        return $this;
    }

    /**
     * @throws ConfigKeyIsEmptyException
     * @throws ConfigKeyNotFoundException
     * @throws ErrorSocketWriteException
     * @throws SocketConstantNotFoundException
     */
    public function write(string $message): self
    {
        $result = socket_write(
            $this->socket,
            $message,
            $this->config->getMaxLength()
        );

        if ($result === false) {
            throw new ErrorSocketWriteException('Failed to send message: ' . $this->getError());
        }

        return $this;
    }

    /**
     * @throws ConfigKeyIsEmptyException
     * @throws ConfigKeyNotFoundException
     * @throws ErrorSocketReceiveException
     * @throws SocketConstantNotFoundException
     */
    public function readMessage(): string
    {
        $result = socket_recv(
            $this->socket,
            $message,
            $this->config->getMaxLength(),
            $this->config->getFlags()
        );

        if ($result === false) {
            throw new ErrorSocketReceiveException('Failed to receive message: ' . $this->getError());
        }

        return $message ?? '';
    }

    protected function getError(): string
    {
        $errorCode = socket_last_error($this->socket);
        return socket_strerror($errorCode);
    }
}
