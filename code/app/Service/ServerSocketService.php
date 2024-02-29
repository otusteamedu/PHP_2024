<?php

declare(strict_types=1);

namespace IGalimov\Hw5\Service;

class ServerSocketService extends SocketService
{
    /**
     * @return \Generator
     * @throws \Exception
     */
    public function socketInProcess(): \Generator
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

        yield "$from:\n $buf \n";
    }
}
