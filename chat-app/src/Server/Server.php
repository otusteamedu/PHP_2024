<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp\Server;

use Sfadeev\ChatApp\Socket\UnixSocket;

class Server
{
    private UnixSocket $inputSock;
    private UnixSocket $outputSock;
    private mixed $output;

    public function __construct(UnixSocket $inputSock, UnixSocket $outputSock, mixed $output)
    {
        $this->inputSock = $inputSock;
        $this->outputSock = $outputSock;
        $this->output = $output;
    }

    public function listen(int $msgLength = 255): void
    {
        $this->inputSock->bind();

        $consumer = new MessageConsumer($this->inputSock);

        fwrite($this->output, 'Server is ready to receive messages.' . PHP_EOL);

        while (true) {
            $msg = $consumer->consume($msgLength);

            $this->outputSock->send(sprintf('Received: %d bytes.', strlen($msg)));

            $outputInfo = sprintf('Received message: "%s".' . PHP_EOL, $msg);

            fwrite($this->output, $outputInfo);
        }
    }
}
