<?php

namespace Naimushina\Chat;

class Server
{
    /**
     * @var Socket
     */
    private Socket $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;

    }

    public function run()
    {
        $this->socket->create();
        //TODO to config
        $server_side_sock = '/code/src/socket/socket.sock';
        $this->socket->bind($server_side_sock);
        $this->socket->listen();
        echo 'created connection';
        do {
            $connectionSocket = $this->socket->accept();
            //todo length to config
            $message = $this->socket->read($connectionSocket, 2048);
            echo $message;
           $this->socket->write($connectionSocket, 'received');

        } while (true);

    }

}
