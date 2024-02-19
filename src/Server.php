<?php

namespace Ahor\Hw5;

class Server extends Chat
{
    public function __construct(Config $config)
    {
        parent::__construct($config);

        $this->create(true);
        $this->bind();
        $this->listen();
    }

    public function start(): \Generator
    {
        yield "Старт сервера" . PHP_EOL;
        $client = $this->accept();

        $run = true;
        while ($run) {
            $message = $this->receive($client);

            if ($message === 'stop') {
                socket_close($client);
                $run = false;
            }

            if ($message) {
                yield "Пришло сообщение" . PHP_EOL;
                yield $message . PHP_EOL;
            }
        }

        $this->close();
    }
}
