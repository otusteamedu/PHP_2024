<?php

declare(strict_types=1);

namespace PavelMiasnov\PhpSocketChat;

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
    }

    /**
     * @throws Exception
     */
    public function app(): void
    {
        $this->server->bind();
        $this->server->listen();
        $this->server->accept();

        while (true) {
            try {
                $msg = $this->server->readMessage();
                if (trim($msg) == 'exit') {
                    echo "Клиент закончил сеанс \n";
                    break;
                } else {
                    echo "Новое сообщение: $msg";
                }
            } catch (Exception $e) {
                throw new Exception("Не удалось прочитать соообщение");
            }
        }
        echo 'Success end' . PHP_EOL;
        $this->server->closeSession();
    }
}
