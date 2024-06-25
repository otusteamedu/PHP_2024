<?php

declare(strict_types=1);

namespace Otus\Chat;

class Server
{
    public function run()
    {
        $socket = new Socket();
        $socket->init();

        while (1) // server never exits
        {
            $data = $socket->receive();
            // $data .= "->Response";  // process client query here
            $socket->send($data);
        }
    }
}
