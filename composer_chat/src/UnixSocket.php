<?php

namespace Chat\socket;
use Exception;

class UnixSocket
{
    public $host;
    public $port;
    public $maxlen;
    public $socket;
    public $client;

    function __construct($host, $port, $maxlen)
    {
        $this->host = $host;
        $this->port = $port;
        $this->maxlen = $maxlen;

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    public function appServer()
    {
        socket_bind($this->socket, $this->host, $this->port);
        socket_listen($this->socket, 1);
        $this->client = socket_accept($this->socket);
    }

    public function appClient()
    {
        socket_connect($this->socket, $this->host, $this->port);
    }

    public function sendingMessages()
    {
        while (true) {
            $msg = readline("Введите сообщение: ") . "\n";
            socket_write($this->socket, $msg);

            if (strpos($msg, "STOP") === true){
                break;
            };
        };
    }

    public function readingMessages()
    {
        while (true) {
            $msg = socket_read($this->client, $this->maxlen, PHP_NORMAL_READ);

            if ($msg){
                if (strpos($msg, "STOP") === true){
                    echo "Клиент звкончил сеанс \n";
                    break;
                }
                else {
                    echo "Новое сообщение: $msg";
                };
            }
            else{
                throw new Exception("Не удалось прочитать соообщение");
            };
        }
    }

    public function closeSession()
    {
        socket_close($this->socket);
    }
}