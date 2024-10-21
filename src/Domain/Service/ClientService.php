<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Controller\Enum\ServiceCommand;
use App\Controller\Enum\ServiceMessage;
use App\Controller\Exception\SocketException;
use App\Domain\Interface\ChatKeepingInterface;
use Generator;

class ClientService implements ChatKeepingInterface
{
    /**
     * @var SocketService
     */
    private SocketService $socketService;

    /**
     * @return string
     * @throws SocketException
     */
    public function initializeChat(): string
    {
        $this->socketService = new SocketService();
        $this->socketService->create();
        $this->socketService->connect();

        return ServiceMessage::ClientStarted->value;
    }

    /**
     * @return Generator
     * @throws SocketException
     */
    public function keepChat(): Generator
    {
        foreach ($this->socketService->getReadGenerator() as $serverMessage) {
            yield ServiceMessage::ServerMessage->value . $serverMessage . PHP_EOL;

            $clientMessage = trim(readline(ServiceMessage::ClientInvitation->value));
            $this->socketService->write($clientMessage);

            if ($clientMessage === ServiceCommand::ChatStop->value) {
                break;
            }
        }
    }

    /**
     * @return Generator
     */
    public function stopChat(): Generator
    {
        $this->socketService->close();

        yield ServiceMessage::ClientStopped->value;
    }
}
