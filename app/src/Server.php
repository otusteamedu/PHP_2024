<?php

namespace Dsergei\Hw5;

class Server extends AbstractSocket
{
    /**
     * @return void
     * @throws \Exception
     */
    public function init(): void
    {
        $this->check();
        $this->create();
        $this->bind();
        $this->listen();

        foreach ($this->logGenerator() as $status) {
            echo $status . PHP_EOL;
        }

        $client = $this->accept();

        $listening = true;

        while ($listening) {
            $message = $this->receive($client);

            echo "Received socket message: {$message}";

            if ($message === 'close') {
                $listening = false;
            }
        }

        $this->close();
    }

    public function logGenerator(): \Generator
    {
        $list = [
            'Check old socket',
            'Create socket',
            'Listen socket',
            'Wait socket'
        ];

        foreach ($list as $status) {
            yield $status;
        }
    }
}
