<?php

namespace Otus\Hw5;

class Server extends AbstractUnixSocket
{
    /**
     * @return void
     * @throws \Exception
     */
    public function startChat(): void
    {
        $this->recreate();
        $this->create();
        $this->bind();
        $this->listen();

        foreach ($this->logGenerator() as $log) {
            echo $log . PHP_EOL;
        }

        $client = $this->accept();

        $isRunning = true;
        while ($isRunning) {
            $message = $this->receive($client);

            if ($message === 'close') {
                socket_close($client);
                $isRunning = false;
            }

            if ($message) {
                echo "Received message: {$message}" . PHP_EOL;
            }
        }

        $this->close();
    }

    /**
     * @return \Generator
     */
    public function logGenerator(): \Generator
    {
        $logs = [
            'Socket re-created!',
            'Socket created!',
            'Socket is successfully bound!',
            'Server listening on socket...',
        ];

        foreach ($logs as $log) {
            yield $log;
        }
    }
}
