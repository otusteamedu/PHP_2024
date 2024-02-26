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
        $this->log()->send("Create server");
        $this->check();
        $this->create();

        $this->log()->send("Bind to server");
        $this->bind();

        $this->log()->send("Listen server");
        $this->listen();

        $this->log()->send("Accept message to client");
        $client = $this->accept();

        $listening = true;
        while ($listening) {
            $message = $this->receive($client);

            if ($message === 'close') {
                socket_close($client);
                $listening = false;
            }

            if ($message) {
                $this->log()->send("Receive message: {$message}");
            }
        }

        $this->log()->send("Close connect");
        $this->close();
    }
}
