<?php

class Server {
    private $socket;

    public function __construct() {
        $this->createSocket();
    }

    private function createSocket() {
        $this->socket = stream_socket_server("unix:///app/shared_volume/chat.sock", $errno, $errstr);
        if (!$this->socket) {
            throw new Exception("Не удалось создать сокет: $errstr ($errno)");
        }
    }

    public function run() {
        while ($client = @stream_socket_accept($this->socket)) {
            $message = fread($client, 1024);
            if ($message === false) {
                fclose($client);
                continue;
            }
            fwrite(STDOUT, "Получено сообщение: " . trim($message) . "\n");
            fwrite($client, "Received " . strlen($message) . " bytes");
            fclose($client);
        }
        fclose($this->socket);
    }
}
