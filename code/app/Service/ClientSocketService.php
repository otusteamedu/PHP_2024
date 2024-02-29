<?php

declare(strict_types=1);

namespace IGalimov\Hw5\Service;

class ClientSocketService extends SocketService
{
    /**
     * @param string|null $serverSocketPath
     * @return \Generator
     * @throws \Exception
     */
    public function socketInProcess(string $serverSocketPath = null): \Generator
    {
        $message = readline("Type: ");

        $this->unblockSocket();

        $this->sendMessage($message, $serverSocketPath);

        if ($message == '!exit') {
            $this->closeSocket();
        }

        $this->blockSocket();

        $buf = '';
        $from = '';

        extract($this->receiveMessages($buf, $from));

        yield "$from:\n $buf \n";
    }
}
