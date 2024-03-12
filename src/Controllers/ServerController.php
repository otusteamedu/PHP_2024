<?php

declare(strict_types=1);

namespace Src\Controllers;

class ServerController
{
    public function run()
    {
        $socketController = new SocketController();
        $socket = $socketController->createSocket();
        $socketController->bindSocket($socket);
        $socketController->listenSocket($socket);
        
        do {
            $clientSocket = $socketController->acceptSocket($socket);
            $welcomeMsg = "Welcome to the server";
            $socketController->writeSocket($clientSocket, $welcomeMsg);

            do {
                $socketController->readSocket($clientSocket);
                
            } while (true);

            $socketController->closeSocket($socket);
        } while (true);
    }
}
