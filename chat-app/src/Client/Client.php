<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp\Client;

use RuntimeException;
use Sfadeev\ChatApp\Socket\UnixSocket;

class Client
{
    private UnixSocket $inputSock;
    private UnixSocket $outputSock;
    private mixed $input;
    private mixed $output;

    public function __construct(UnixSocket $outputSock, UnixSocket $inputSock, mixed $input, mixed $output)
    {
        $this->inputSock = $inputSock;
        $this->outputSock = $outputSock;
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
        $this->inputSock->bind();

        $producer = new MessageProducer($this->outputSock);

        while (true) {
            if (!$this->sendMessageInteractive($producer)) {
                $this->inputSock->close();
                break;
            }
        }
    }

    /**
     * @param MessageProducer $client
     * @return bool
     *
     * @throws RuntimeException
     */
    private function sendMessageInteractive(MessageProducer $client): bool
    {
        fwrite($this->output, '---' . PHP_EOL);
        fwrite($this->output, 'Enter your message (empty string for exit):' . PHP_EOL);

        $msg = trim(fgets($this->input));

        if ('' === $msg) return false;

        $client->send($msg);

        fwrite($this->output, 'Message has been sent.' . PHP_EOL);

        $serverResponse = $this->inputSock->read(64);

        fwrite($this->output, sprintf('Message from server: "%s"' . PHP_EOL, $serverResponse));

        return true;
    }
}
