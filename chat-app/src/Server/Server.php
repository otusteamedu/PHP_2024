<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp\Server;

use RuntimeException;
use Sfadeev\ChatApp\Socket\UnixSocket;

class Server
{
    private UnixSocket $socket;
    private mixed $output;

    /**
     * @param UnixSocket $socket
     * @param mixed $output
     */
    public function __construct(UnixSocket $socket, mixed $output)
    {
        $this->socket = $socket;
        $this->output = $output;
    }

    /**
     * @return void
     *
     * @throws RuntimeException
     */
    public function listen(): void
    {
        $this->socket->bind();

        fwrite($this->output,  'Сервер готов принимать сообщения.' . PHP_EOL);

        while (true) {
            $data = $this->socket->read(64);

            $outputInfo = sprintf('Получено сообщение: "%s"' . PHP_EOL, $data);

            fwrite($this->output,  $outputInfo);
        }
    }
}
