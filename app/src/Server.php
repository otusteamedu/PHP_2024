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

}