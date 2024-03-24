<?php

namespace IraYu\Service;

use IraYu\Service;

class Server
{
    public function __construct(protected $socketPath)
    {
    }

    public function start()
    {
        $socket = new Service\UnixSocket();
        $socket
            ->bind($this->socketPath)
            ->listen()
        ;

        $clientSockets = [];
        $loopPointer = 0;
        do {
            $count = count($clientSockets);
            echo sprintf("Clients count: %s[%d]%s", $count, $loopPointer++, PHP_EOL);

            if ($newSocket = $socket->accept()) {
                $clientSockets[] = $newSocket;
                $count = count($clientSockets);

                $newSocket->write('Your number is: ' . $count);
                echo sprintf("New client connected [%d]%s", $count, PHP_EOL);
            }

            for ($i = 0; $i < $count; $i++) {
                $clientSocket = $clientSockets[$i];
                if (null === ($clientMessage = $clientSocket->recv())) {
                    unset($clientSockets[$i]);
                } else if ($clientMessage !== '') {
                    // Broadcast message to all clients except the sender
                    foreach ($clientSockets as $client) {
                        $message = $client === $clientSocket ? 'accepted' : $clientMessage;
                        try {
                            $client->write($message);
                        } catch (\Throwable $e) {
                            unset($clientSockets[$i]);
                        }
                    }
                }
            }
            sleep(1);
        } while (true);
    }
}
