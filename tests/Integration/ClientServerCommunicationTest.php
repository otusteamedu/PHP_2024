<?php

namespace Tests\Integration;

use App\Sockets\ClientSocket;
use App\Sockets\ServerSocket;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ClientServerCommunicationTest extends TestCase
{
    private MockObject $clientSocket;
    private MockObject $serverSocket;

    public function setUp(): void
    {
        $this->serverSocket = $this->createMock(ServerSocket::class);
        $this->clientSocket = $this->createMock(ClientSocket::class);
    }

    public function tearDown(): void
    {
        unset($this->serverSocket);
        unset($this->clientSocket);
    }

    public function testClientSendsMessageToServer()
    {
        $this->serverSocket->method('listen')->willReturn($this->getServerResponses());
        $this->clientSocket->method('listen')->willReturn($this->getClientResponses());

        foreach ($this->serverSocket->listen() as $response) {
            $this->assertSame('Received message: Hello Client.', $response);
        }

        foreach ($this->clientSocket->listen() as $response) {
            $this->assertSame('Enter your message: ', $response);
        }
    }

    private function getServerResponses(): Generator
    {
        yield 'Received message: Hello Client.';
    }

    private function getClientResponses(): Generator
    {
        yield 'Enter your message: ';
    }
}
