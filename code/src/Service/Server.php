<?php

namespace IraYu\Service;

use IraYu\Service;

class Server extends ChatElement
{
    public function start(): void
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
            $this->log(sprintf("Clients count: %s[%d]", $count, $loopPointer++));

            if ($newSocket = $socket->accept()) {
                $clientSockets[] = $newSocket;
                $count = count($clientSockets);

                $newSocket->write('Your number is: ' . $count);
                $this->log(sprintf("New client connected [%d]", $count));
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
