<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\ServiceCommand;
use App\Enum\ServiceMessage;
use App\Interface\ChatBeginningInterface;
use App\Interface\ChatKeepingInterface;
use Exception;
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
     * @return void
     * @throws Exception
     */
    public function initializeChat(): void
    {
        $this->socketService = new SocketService();
        $this->socketService->create();
        $this->socketService->bind();
        $this->socketService->listen();

        echo ServiceMessage::ServerStarted->value;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function beginChat(): void
    {
        $this->socket = $this->socketService->accept();
        $serverMessage = ServiceMessage::WelcomeToChat->value;
        $this->socketService->write($serverMessage,  $this->socket);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function keepChat(): void
    {
        foreach ($this->socketService->getReadGenerator($this->socket) as $clientMessage) {

            if ($clientMessage === ServiceCommand::ChatStop->value) {
                break;
            }

            echo ServiceMessage::ClientMessage->value . $clientMessage . PHP_EOL;

            $serverMessage = ServiceMessage::ServerAnswer->value . $clientMessage
                             . ServiceMessage::ReceivedBytes->value . strlen($clientMessage);
            $this->socketService->write($serverMessage, $this->socket);
        }
    }

    /**
     * @return void
     */
    public function stopChat(): void
    {
        $this->socketService->close();
        $this->socketService->unlink();

        echo ServiceMessage::ClientStoppedChat->value;
        echo ServiceMessage::ServerStopped->value;
    }
}
