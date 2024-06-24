<?php

declare(strict_types=1);

namespace Otus\Chat;

class Server
{
    private $socket;

    public function __construct(Socket $socket)
    {
        // $this->socket = $socket->create();
        // $socket->bind();

        // while (1) {
        //     $socket->block();
        //     $buf = '';
        //     $from = '';
        //     $bytes_received = $socket->recvfrom();
        //     echo "Received $buf from $from\n";
        //     $buf .= "->Response"; // process client query here

        //     $socket->unblock();
        //     $len = strlen($buf);
        //     $bytes_sent = $socket->sendto();
        //     echo "Request processed\n";
        // }

    }
}
