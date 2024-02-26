<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Socket\Abstract;

use Kiryao\Sockchat\Config\DTO\Socket;
use Kiryao\Sockchat\Config\DTO\SocketPath;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketCreateException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketReadException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketWriteException;
use Socket as BaseSocket;

abstract class AbstractSocket
{
    protected BaseSocket $socket;

    public function __construct(
        protected Socket\Config $socketConfig,
        protected SocketPath\Config $socketPathConfig
    ) {
    }

    /**
     * @return AbstractSocket
     * @throws ErrorSocketCreateException
     */
    public function create(): self
    {
        $socket = socket_create(
            $this->socketConfig->getDomain(),
            $this->socketConfig->getType(),
            $this->socketConfig->getProtocol()
        );

        if ($socket === false) {
            throw new ErrorSocketCreateException($this->getError());
        }

        $this->socket = $socket;

        return $this;
    }

    public function close(): self
    {
        socket_close($this->socket);
        return $this;
    }

    /**
     * @param string $message
     * @return AbstractSocket
     * @throws ErrorSocketWriteException
     */
    public function write(string $message): self
    {
        $result = socket_write(
            $this->socket,
            $message,
            $this->socketConfig->getMaxLength()
        );

        if ($result === false) {
            throw new ErrorSocketWriteException($this->getError());
        }

        return $this;
    }

    /**
     * @return string
     * @throws ErrorSocketReadException
     */
    public function readMessage(): string
    {
        $result = socket_recv(
            $this->socket,
            $message,
            $this->socketConfig->getMaxLength(),
            $this->socketConfig->getFlags()
        );

        if ($result === false) {
            throw new ErrorSocketReadException($this->getError());
        }

        return $message ?? '';
    }

    protected function getError(): string
    {
        $errorCode = socket_last_error($this->socket);
        return socket_strerror($errorCode);
    }
}
