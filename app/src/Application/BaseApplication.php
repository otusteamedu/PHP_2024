<?php

declare(strict_types=1);

namespace Dw\OtusSocketChat\Application;

use Dw\OtusSocketChat\Config\ConfigInterface;
use Exception;
use Socket;

abstract class BaseApplication implements ApplicationInterface
{
    protected Socket $socket;
    protected string $socketPath;
    protected int $maxMessageLength;

    /**
     * @throws Exception
     */
    public function __construct(protected ConfigInterface $config)
    {
        $this->checkSocketExtension();
        $this->socket = $this->createSocket();
        $this->socketPath = $this->config->getConfiguration()['main']['socket'];
        $this->maxMessageLength = (int)$this->config->getConfiguration()['main']['max_length_message'];
    }

    abstract public function run();

    /**
     * @throws Exception
     */
    protected function createSocket(): Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$socket) {
            throw new Exception('Ошибка при создании сокета');
        }

        return $socket;
    }

    /**
     * @throws Exception
     */
    protected function checkSocketExtension(): void
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded.');
        }
    }
}
