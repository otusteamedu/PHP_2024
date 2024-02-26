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

        $client = $this->accept();

        $listening = true;
        while ($listening) {
            $message = $this->receive($client);

            if ($message === 'close') {
                $listening = false;
            }
        }

        $this->close();
    }
}
