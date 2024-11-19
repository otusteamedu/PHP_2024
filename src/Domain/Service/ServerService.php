<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Enum\ServiceCommand;
use App\Domain\Enum\ServiceMessage;
use App\Domain\Exception\SocketException;
use App\Domain\Interface\ChatBeginningInterface;
use App\Domain\Interface\ChatKeepingInterface;
use Generator;
use Socket;

class ServerService implements ChatKeepingInterface, ChatBeginningInterface
{
    private SocketService $socketService;

    private Socket $socket;

    /**
     * @return string
     * @throws SocketException
     */
    public function initializeChat(): string
    {
        $this->socketService = new SocketService();
        $this->socketService->unlink();
        $this->socketService->create();
        $this->socketService->bind();
        $this->socketService->listen();

        return ServiceMessage::ServerStarted->value;
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function beginChat(): void
    {
        $this->socket = $this->socketService->accept();
        $serverMessage = ServiceMessage::WelcomeToChat->value;
        $this->socketService->write($serverMessage, $this->socket);
    }

    /**
     * @return Generator
     * @throws SocketException
     */
    public function keepChat(): Generator
    {
        foreach ($this->socketService->getReadGenerator($this->socket) as $clientMessage) {
            if ($clientMessage === ServiceCommand::ChatStop->value) {
                break;
            }

            yield ServiceMessage::ClientMessage->value . $clientMessage . PHP_EOL;

            $serverMessage = ServiceMessage::ServerAnswer->value . '"' . $clientMessage . '"'
                          . ServiceMessage::ReceivedBytes->value . strlen($clientMessage) . ';'
                          . (new CommandHandlerService())->commandHandler($clientMessage);
            $this->socketService->write($serverMessage, $this->socket);
        }
    }

    public function stopChat(): Generator
    {
        $this->socketService->close();
        $this->socketService->unlink();

        yield ServiceMessage::ClientStoppedChat->value . ServiceMessage::ServerStopped->value;
    }
}
