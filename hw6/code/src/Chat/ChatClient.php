<?php

namespace GoroshnikovP\Hw6\Chat;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;

class ChatClient extends Chat
{
    /**
     * @throws RuntimeException
     */
    public function run(): void
    {
        $this->socketInit($this->socketConfig->fileNameClient);

        $msg = "Пашок 1";
        $this->socketSend($this->socketConfig->fileNameServer, $msg);

        $answerInfo = $this->socketReceive();

        echo "Ответ: {$answerInfo->data}\n";

        socket_close($this->socket);
        unlink($this->socketConfig->fileNameClient);
        echo "Client exits\n";

    }
}
