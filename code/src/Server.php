<?php

declare(strict_types=1);

namespace TimurShakirov\SocketChat;

use Exception;

class Server
{
    public $server;

    public function __construct($host, $port, $length)
    {
        if (file_exists($host)) {
            unlink($host);
        }
        $this->server = new UnixSocket($host, $port, $length);
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
