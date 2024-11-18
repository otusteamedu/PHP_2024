<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Enum\ServiceCommand;
use App\Domain\Enum\ServiceMessage;
use App\Domain\Exception\SocketException;
use App\Domain\Interface\ChatKeepingInterface;
use Generator;

class ClientService implements ChatKeepingInterface
{
    /**
     * @var SocketService
     */
    private SocketService $socketService;

    public function __construct(
        private $inputStream,
        private $outputStream
    ) {
    }

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
            $clientMessage = $this->readLine();
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

    /**
     * @return false|string
     * @codeCoverageIgnore
     */
    private function readLine(): false|string
    {
        fwrite($this->outputStream, ServiceMessage::ClientInvitation->value);

        return  trim(fgets($this->inputStream, 1024));
    }
}
