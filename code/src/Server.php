<?php

declare(strict_types=1);

namespace TimurShakirov\SocketChat;

use Exception;

class Server
{
    public $server;

    public function __construct($file, $length)
    {
        if (file_exists($file)) {
            unlink($file);
        }
        $this->server = new UnixSocket($file, $length);
        echo "Ожидание сообщений. Для выхода нажмите CTRL + C (Windows, Linux) или CMD + C (Mac)" . PHP_EOL;
    }

    /**
     * @throws Exception
     */
    public function app()
    {
        $this->server->bind();
        $this->server->listen();
        $this->server->accept();

        while (true) {
            foreach ($this->server->readMessage() as $msg) {
                echo $msg;
            }
        }
        $this->server->closeSession();
    }
}
