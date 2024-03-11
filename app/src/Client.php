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
        $this->create();
        $this->connect();

        foreach ($this->logGenerator() as $status) {
            echo $status . PHP_EOL;
        }

        $connected = true;
        while ($connected) {
            $message = readline('Enter your message: ');

            $this->send($message);

            if ($message === 'close') {
                $connected = false;
            }
        }
    }

    public function logGenerator(): \Generator
    {
        $list = [
            'Create socket',
            'Connect to socket'
        ];

        foreach ($list as $status) {
            yield $status;
        }
    }
}
