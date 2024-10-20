<?php

class Client {
    private $socket;

    public function __construct() {
        $this->createSocket();
    }

    private function createSocket() {
        $this->socket = stream_socket_client("unix:///app/shared_volume/chat.sock", $errno, $errstr);
        if (!$this->socket) {
            throw new Exception("Не удалось подключиться к серверу: $errstr ($errno)");
        }
    }

    public function run() {
        while ($line = fgets(STDIN)) {
            fwrite($this->socket, $line);
            $response = fread($this->socket, 1024);
            fwrite(STDOUT, "Ответ от сервера: " . trim($response) . "\n");
        }
        fclose($this->socket);
    }
}
