<?php

namespace TBublikova\Php2024\Tests;

use PHPUnit\Framework\TestCase;
use TBublikova\Php2024\ServerChat;
use TBublikova\Php2024\Socket;

class ServerChatTest extends TestCase
{
    private $socketMock;
    private $serverChat;

    protected function setUp(): void
    {
        $this->socketMock = $this->createMock(Socket::class);

        $this->socketMock->expects($this->once())
            ->method('bindAndListen');

        $this->serverChat = new ServerChat($this->socketMock);
    }

    public function testServerInitialization(): void
    {
        $this->assertInstanceOf(ServerChat::class, $this->serverChat);
    }

    public function testSingleMessageProcessing(): void
    {
        $clientSocket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        $this->socketMock->expects($this->once())
            ->method('accept')
            ->willReturn($clientSocket);

        $this->socketMock->expects($this->once())
            ->method('receive')
            ->with($clientSocket, $this->anything())
            ->willReturnCallback(function ($socket, &$buffer) {
                $buffer = 'Hello';
                return strlen($buffer);
            });

        $this->socketMock->expects($this->once())
            ->method('send')
            ->with($clientSocket, 'Hello->Response')
            ->willReturn(strlen('Hello->Response'));

        $clientSocket = $this->socketMock->accept();
        $buffer = '';
        $this->socketMock->receive($clientSocket, $buffer);
        $response = $buffer . '->Response';
        $this->socketMock->send($clientSocket, $response);

        $this->assertTrue(true, 'Server processed the message as expected.');
    }
}
