<?php

namespace Dsergei\Hw5;

class Client extends AbstractSocket
{

    /**
     * @return void
     * @throws \Exception
     */
    public function init(): void
    {
        echo "Create client" . PHP_EOL;
        $this->create();

        echo "Connect to client" . PHP_EOL;
        $this->connect();

        $connected = true;
        while ($connected) {
            $message = readline('Enter your message: ');

            $this->send($message);

            if ($message === 'close') {
                $connected = false;
            }
        }

    }
}