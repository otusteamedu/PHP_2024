<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\ServiceCommand;
use App\Enum\ServiceMessage;
use App\Interface\ChatKeepingInterface;

class ClientService implements ChatKeepingInterface
{
    /**
     * @var SocketService
     */
    private SocketService $socketService;

    /**
     * @return void
     * @throws \Exception
     */
    public function initializeChat(): void
    {
        $this->socketService = new SocketService();
        $this->socketService->create();
        $this->socketService->connect();

        echo ServiceMessage::ClientStarted->value;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function keepChat(): void
    {
        foreach ($this->socketService->getReadGenerator() as $serverMessage) {
            echo ServiceMessage::ServerMessage->value . $serverMessage . PHP_EOL;

            $clientMessage = readline(ServiceMessage::ClientInvitation->value);
            $this->socketService->write($clientMessage);

            if ($clientMessage === ServiceCommand::ChatStop->value) {
                break;
            }
        }
    }

    /**
     * @return void
     */
    public function stopChat(): void
    {
        $this->socketService->close();

        echo ServiceMessage::ClientStopped->value;
    }
}
