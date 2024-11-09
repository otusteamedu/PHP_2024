<?php
namespace AlexAgapitov\OtusComposerProject;

use Exception;

class Server
{
    public UnixSocket $server;

    /**
     * @throws Exception
     */
    public function __construct($file, $length)
    {
        if (file_exists($file)) {
            unlink($file);
        }
        $this->server = new UnixSocket($file, $length);
    }

    /**
     * @throws Exception
     */
    public function connect()
    {
        $this->server->create();
        $this->server->bind();
        $this->server->listen();
        $this->server->accept();
    }

    public function close() {
        $this->server->closeSession();
    }

    /**
     * @throws Exception
     */
    public function app(bool $test = false)
    {
        $this->connect();
        while (true) {
            foreach ($this->getMessage() AS $msg) {
                echo "Пользователь прислал сообщение: " . $msg;
            }
            if ($test) break;
        }
        $this->close();
    }

    public function getMessage(): \Generator
    {
        foreach ($this->server->readMessage() as $msg) {
            yield $msg;
        }
    }
}