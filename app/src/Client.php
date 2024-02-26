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
