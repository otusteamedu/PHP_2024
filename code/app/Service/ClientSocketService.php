<?php

declare(strict_types=1);

namespace IGalimov\Hw5\Service;

class ClientSocketService extends SocketService
{
    /**
     * @param string|null $serverSocketPath
     * @throws \Exception
     */
    public function socketInProcess(string $serverSocketPath = null)
    {
        while ($this->socketStatus) {
            $message = readline("Type: ");

            $this->unblockSocket();

            $this->sendMessage($message, $serverSocketPath);

            if ($message == '!exit') $this->closeSocket();

            $this->blockSocket();

            extract($this->receiveMessages());
        }
    }
}
