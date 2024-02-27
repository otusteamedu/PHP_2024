<?php

declare(strict_types=1);

namespace App;

class SocketStart
{
    public object $result;

    /**
     * @return void
     * @throws SocketErrorException
     */
    public function startServerSocket(): void
    {
        $server = new Server();
        $this->result = $server->createServer();
        foreach ($this->result as $item) {
            print_r($item);
        }
    }

    /**
     * @return void
     * @throws SocketErrorException
     */
    public function startClientSocket(): void
    {
        $server = new Client();
        $this->result = $server->createClient();
        foreach ($this->result as $item) {
            print_r($item);
        }
    }
}
