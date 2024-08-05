<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw5;

class App
{
    public function run()
    {
        $command = $_SERVER['argv'][1];

        switch ($command) {
            case 'client':
                echo "Client started. You can send your messages below" . PHP_EOL;
                $client = new Client(CLIENT_SOCKET_FILE_NAME);
                $output = $client->process();
                break;
            case 'server':
                echo "Server started. Listening for client messages..." . PHP_EOL;
                $server = new Server(SERVER_SOCKET_FILE_NAME);
                $output = $server->process();
                break;
        }

        if (!empty($output)) {
            foreach ($output as $entry) {
                echo $entry;
            }
        }
    }
}
