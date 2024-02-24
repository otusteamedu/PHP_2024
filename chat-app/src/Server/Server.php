<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp\Server;

use Exception;
use RuntimeException;
use Sfadeev\ChatApp\Config;
use Sfadeev\ChatApp\Socket\UnixSocket;

class Server
{
    private Config $config;
    private mixed $output;

    public function __construct(Config $config, mixed $output)
    {
        $this->config = $config;
        $this->output = $output;
    }

    /**
     * @return void
     *
     * @throws RuntimeException
     */
    public function listen(): void
    {
        $masterSock = UnixSocket::create();
        $masterSock->bind($this->config->getSocketPath());
        $masterSock->listen();

        while (true) {
            fwrite($this->output, 'Server is ready to receive connection.' . PHP_EOL);

            try{
                $connSock = $masterSock->accept();
            } catch (Exception $e) {
                $masterSock->close();
                unlink($this->config->getSocketPath());
                throw $e;
            }

            fwrite($this->output, 'Connection established.' . PHP_EOL);

            while (true) {
                $msg = $connSock->read($this->config->getMessageMaxLength());

                if (null === $msg) {
                    fwrite($this->output, 'Connection closed.' . PHP_EOL);
                    $connSock->close();
                    break;
                }

                $connSock->send(sprintf('Received: %d bytes.', strlen($msg)));

                $outputInfo = sprintf('Received message: "%s".' . PHP_EOL, $msg);

                fwrite($this->output, $outputInfo);
            }
        }
    }
}
