<?php

namespace TBublikova\Php2024\Tests;

use PHPUnit\Framework\TestCase;
use TBublikova\Php2024\ClientChat;
use TBublikova\Php2024\Socket;

class ClientChatTest extends TestCase
{
    private $socketMock;
    private $clientChat;

    protected function setUp(): void
    {
        $this->socketMock = $this->createMock(Socket::class);

        $this->clientChat = new ClientChat($this->socketMock);
    }

    public function testClientInitialization(): void
    {
        $this->assertInstanceOf(ClientChat::class, $this->clientChat);
    }

    public function testConnectToServer(): void
    {
        $this->socketMock->expects($this->once())
            ->method('connect');

        $this->socketMock->expects($this->once())
            ->method('getSocket')
            ->willReturn(socket_create(AF_UNIX, SOCK_STREAM, 0));

        $reflection = new \ReflectionClass($this->clientChat);
        $method = $reflection->getMethod('connectToServer');
        $method->setAccessible(true);
        $method->invoke($this->clientChat);
    }

    public function testSendMessage(): void
    {
        $clientSocket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        $this->socketMock->expects($this->once())
            ->method('send')
            ->with($clientSocket, 'Hello')
            ->willReturn(strlen('Hello'));

        $this->socketMock->expects($this->once())
            ->method('getSocket')
            ->willReturn($clientSocket);

        $reflection = new \ReflectionClass($this->clientChat);
        $connectMethod = $reflection->getMethod('connectToServer');
        $connectMethod->setAccessible(true);
        $connectMethod->invoke($this->clientChat);

        $sendMessageMethod = $reflection->getMethod('sendMessage');
        $sendMessageMethod->setAccessible(true);
        $sendMessageMethod->invoke($this->clientChat, 'Hello');
    }

    public function testReceiveResponse(): void
    {
        $clientSocket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        $this->socketMock->expects($this->once())
            ->method('receive')
            ->with($clientSocket, $this->anything())
            ->willReturnCallback(function ($socket, &$buffer) {
                $buffer = 'Hello->Response';
                return strlen('Hello->Response');
            });

        $this->socketMock->expects($this->once())
            ->method('getSocket')
            ->willReturn($clientSocket);

        $reflection = new \ReflectionClass($this->clientChat);
        $connectMethod = $reflection->getMethod('connectToServer');
        $connectMethod->setAccessible(true);
        $connectMethod->invoke($this->clientChat);

        $receiveResponseMethod = $reflection->getMethod('receiveResponse');
        $receiveResponseMethod->setAccessible(true);
        $receiveResponseMethod->invoke($this->clientChat);
    }

    public function testCloseConnection(): void
    {
        $clientSocket = socket_create(AF_UNIX, SOCK_STREAM, 0);

         $this->socketMock->expects($this->once())
            ->method('close')
            ->with($clientSocket);

        $this->socketMock->expects($this->once())
            ->method('getSocket')
            ->willReturn($clientSocket);

        $reflection = new \ReflectionClass($this->clientChat);
        $connectMethod = $reflection->getMethod('connectToServer');
        $connectMethod->setAccessible(true);
        $connectMethod->invoke($this->clientChat);

        $closeConnectionMethod = $reflection->getMethod('closeConnection');
        $closeConnectionMethod->setAccessible(true);
        $closeConnectionMethod->invoke($this->clientChat);
    }
}
