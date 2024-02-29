<?php

declare(strict_types=1);

namespace IGalimov\Hw5;

use IGalimov\Hw5\Service\ClientSocketService;
use IGalimov\Hw5\Service\ServerSocketService;

class App
{
    const PATH_TO_SERVER_SOCKET = '/../../server/server.sock';
    const PATH_TO_CLIENT_SOCKET = '/../../server/client.sock';

    /**
     * @throws \Exception
     */
    public function run()
    {
        if ($_SERVER['argc'] !== 2) {
            throw new \Exception("Wrong command arguments count.");
        }

        switch ($_SERVER['argv'][1]) {
            case 'client':
                $client = $this->runClient();
                foreach ($client as $item) {
                    yield $item;
                }
                break;
            case 'server':
                $server = $this->runServer();
                foreach ($server as $item) {
                    yield $item;
                }
                break;
            default:
                throw new \Exception("Wrong command.");
                break;
        }
    }

    /**
     * @throws \Exception
     */
    public function runServer()
    {
        $socketService = new ServerSocketService();

        $socketService->createSocket(dirname(__FILE__) . self::PATH_TO_SERVER_SOCKET);

        while ($socketService->socketStatus) {
            $processes = $socketService->socketInProcess();
            foreach ($processes as $process) {
                yield $process;
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function runClient()
    {
        $socketService = new ClientSocketService();

        if (!$socketService->checkSocketExists(dirname(__FILE__) . self::PATH_TO_SERVER_SOCKET)) {
            throw new \Exception("Server is offline.");
        }

        $socketService->createSocket(dirname(__FILE__) . self::PATH_TO_CLIENT_SOCKET);

        yield "Chat is ready (type '!exit' to stop):\n";

        while ($socketService->socketStatus) {
            $processes = $socketService->socketInProcess(dirname(__FILE__) . self::PATH_TO_SERVER_SOCKET);
            foreach ($processes as $process) {
                yield $process;
            }
        }
    }
}
