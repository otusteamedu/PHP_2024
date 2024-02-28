<?php

declare(strict_types=1);

namespace IGalimov\Hw5\Service;

class ServerSocketService extends SocketService
{
    /**
     * @throws \Exception
     */
    public function socketInProcess(): string
    {
        $this->blockSocket();

        $buf = '';
        $from = '';

        extract($this->receiveMessages($buf, $from));

        if ($buf == '!exit') {
            $this->closeSocket();
        }

        $this->unblockSocket();

        $this->sendMessage('Message received by server...', $from);

        return "$from:\n $buf \n";
    }
}
