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
        echo 'Creating socket...' . PHP_EOL;
        $this->create();
        echo 'Socket created!' . PHP_EOL;

        echo 'Connecting socket...' . PHP_EOL;
        $this->connect();
        echo "Socket connection established successfully!" . PHP_EOL;

        $isRunning = true;
        while ($isRunning) {
            $message = readline('Enter your message: ');

            $this->send($message);

            if ($message === 'close') {
                $isRunning = false;
            }
        }
    }
}
