<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\ServiceCommand;
use App\Enum\ServiceMessage;
use App\Exception\SocketException;
use App\Interface\ChatBeginningInterface;
use App\Interface\ChatKeepingInterface;
use Generator;
use Socket;

class ServerService implements ChatKeepingInterface, ChatBeginningInterface
{
    /**
     * @var SocketService
     */
    private SocketService $socketService;

    /**
     * @var Socket
     */
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

    /**
     * @return Generator
     */
    public function stopChat(): Generator
    {
        $this->socketService->close();
        $this->socketService->unlink();

        yield ServiceMessage::ClientStoppedChat->value . ServiceMessage::ServerStopped->value;
    }
}
