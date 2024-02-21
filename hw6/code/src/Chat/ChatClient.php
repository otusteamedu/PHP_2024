<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\Chat;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;
use GoroshnikovP\Hw6\Exceptions\RuntimeNotCriticalException;

class ChatClient extends Chat
{
    /**
     * @throws RuntimeException
     */
    public function run(): void
    {
        $this->socketInit($this->socketConfig->fileNameClient);
        while (true) {
            try {
                $msg = readline('Какое сообщение отправить? ');
                if (parent::CLIENT_EXIT === $msg) {
                    $this->clientBreak();
                    break;
                }

                $this->socketSend($this->socketConfig->fileNameServer, $msg);

                $answerInfo = $this->socketReceive();
                echo "Ответ: {$answerInfo->data}\n";
            } catch (RuntimeNotCriticalException $ex) {
                echo $ex->getMessage() . "\n";
            }
        }
    }

    private function clientBreak()
    {
        socket_close($this->socket);
        $fileName = $this->socketConfig->fileNameClient;
        if (file_exists($fileName)) {
            unlink($fileName);
        }
        echo 'Client exits';
    }
}
