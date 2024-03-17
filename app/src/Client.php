<?php

namespace Otus\Hw5;

class Client extends AbstractUnixSocket
{
    /**
     * @return void
     * @throws \Exception
     */
    public function startChat(): void
    {
        $this->create();
        $this->connect();

        foreach ($this->logGenerator() as $log) {
            echo $log . PHP_EOL;
        }

        $isRunning = true;
        while ($isRunning) {
            $message = readline('Enter your message: ');

            $this->send($message);

            if ($message === 'close') {
                $isRunning = false;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function logGenerator(): \Generator
    {
        $logs = [
            'Socket created!',
            'Socket connection established successfully!'
        ];

        foreach ($logs as $log) {
            yield $log;
        }
    }
}
