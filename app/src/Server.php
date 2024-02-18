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
        echo "Create server" . PHP_EOL;
        $this->check();
        $this->create();

        echo "Bind to server" . PHP_EOL;
        $this->bind();

        echo "Listen server" . PHP_EOL;
        $this->listen();

        echo "Accept message to client" . PHP_EOL;
        $client = $this->accept();

        $listening = true;
        while ($listening) {
            $message = $this->receive($client);

            if ($message === 'close') {
                socket_close($client);
                $listening = false;
            }

            if ($message) {
                echo "Receive message: {$message}" . PHP_EOL;
            }
        }

        $this->close();
    }
}
