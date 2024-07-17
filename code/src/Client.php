<?php

namespace Naimushina\Chat;

class Client
{
    /**
     * @var Socket
     */
    private Socket $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;

    }

    /**
     * @throws \Exception
     */
    public function run(){

        $this->socket->create();
        //TODO to config
        $server_side_sock = '/code/src/socket/socket.sock';
        $this->socket->connect($server_side_sock);
        while (true) {
            $message = fgets(STDIN);
            $this->socket->write($this->socket->unixSocket, $message);

            if ($message === 'exit') {
                break;
            }
        }
        $this->socket->close($this->socket->unixSocket);
    }

}
