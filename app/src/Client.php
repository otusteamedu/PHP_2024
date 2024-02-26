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
        $this->log()->send('Create client');
        $this->create();

        $this->log()->send('Connect to client');
        $this->connect();

        $connected = true;
        while ($connected) {
            $message = readline('Enter your message: ');

            $this->send($message);

            if ($message === 'close') {
                $this->log()->send('Close connect to client');
                $connected = false;
            }
        }
    }
}
