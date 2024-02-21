<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Service;

use AleksandrOrlov\Php2024\Configuration\Service as Configuration;
use AleksandrOrlov\Php2024\Socket\Service as SocketService;
use Exception;
use Generator;

class Client implements NetworkInterface
{
    private SocketService $socketService;

    public function __construct()
    {
        $this->socketService = new SocketService();
    }

    /**
     * @throws Exception
     */
    public function run(): Generator
    {
        yield "Client started\n";
        $config = Configuration::getConfig();

        $socket = $this->socketService->create();

        $this->socketService->bind($socket, $config['client_socket_file_path']);

        while (true) {
            $msg = trim(fgets(STDIN));

            $this->socketService->send($socket, $msg, $config['server_socket_file_path']);

            $this->socketService->receive($socket);
        }
    }
}
