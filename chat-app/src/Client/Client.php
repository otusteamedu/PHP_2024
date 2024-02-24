<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp\Client;

use RuntimeException;
use Sfadeev\ChatApp\Config;
use Sfadeev\ChatApp\Socket\UnixSocket;

class Client
{
    private Config $config;
    private mixed $input;
    private mixed $output;

    public function __construct(Config $config, mixed $input, mixed $output)
    {
        $this->config = $config;
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @return void
     *
     * @throws RuntimeException
     */
    public function startMessaging(): void
    {
        $socketPath = $this->config->getSocketPath();

        if (!file_exists($socketPath)) {
            throw new RuntimeException(sprintf("Socket %s doesn't exist. Probable reason - the server is not running.", $socketPath));
        }

        $socket = UnixSocket::create();

        $socket->connect($socketPath);

        while (true) {
            if (!$this->sendMessageInteractive($socket)) {
                break;
            }
        }
    }

    /**
     * @param UnixSocket $socket
     * @return bool
     *
     * @throws RuntimeException
     */
    private function sendMessageInteractive(UnixSocket $socket): bool
    {
        fwrite($this->output, '---' . PHP_EOL);
        fwrite($this->output, 'Enter your message (empty string for exit):' . PHP_EOL);

        $msg = trim(fgets($this->input));

        if ('' === $msg) {
            return false;
        }

        $socket->send($msg);

        fwrite($this->output, 'Message has been sent.' . PHP_EOL);

        $serverResponse = $socket->read($this->config->getMessageMaxLength());

        fwrite($this->output, sprintf('Message from server: "%s"' . PHP_EOL, $serverResponse));

        return true;
    }
}
