<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Service;

use Exception;
use AleksandrOrlov\Php2024\Configuration\Service as Configuration;
use AleksandrOrlov\Php2024\Socket\Service as SocketService;

class Server implements NetworkInterface
{
    private SocketService $socketService;

    public function __construct()
    {
        $this->socketService = new SocketService();
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        $config = Configuration::getConfig();

        // create unix udp socket
        $socket = $this->socketService->create();

        $this->socketService->bind($socket, $config['server_socket_file_path']);

        while (true) {
            echo "Ready to receive...\n";

            list($buf, $from) = $this->socketService->receive($socket);

            $buf .= "->Response"; // process client query here

            $this->socketService->send($socket, $buf, $from);

            echo "Request processed\n";
        }
    }
}
