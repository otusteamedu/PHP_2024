<?php

namespace Chat\server;

use Chat\socket\UnixSocket as Socket;

class Server
{
    public $server;

    public function __construct($host, $port, $maxlen)
    {
        if (file_exists($host)) {
            unlink($host);
        }
        $this->server = new Socket($host, $port, $maxlen);
    }

    public function app()
    {
        $this->server->socketBind();
        $this->server->socketListen();
        $this->server->socketAccept();
        while (true) {
            $msg = $this->server->readMessage();
            if ($msg) {
                if (strpos($msg, "STOP") === true) {
                    echo "Клиент звкончил сеанс \n";
                    break;
                }
                else {
                    echo "Новое сообщение: $msg";
                };
            }
            else {
                throw new Exception("Не удалось прочитать соообщение");
            };
        };
        $this->server->closeSession();
    }
}
