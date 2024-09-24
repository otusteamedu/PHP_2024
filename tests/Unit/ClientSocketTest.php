<?php

use App\Sockets\ClientSocket;
use App\Config\SocketConfig;
use PHPUnit\Framework\TestCase;

class ClientSocketTest extends TestCase
{
    public function testClientSocketBindsToCorrectSocket()
    {
        $socketConfigMock = $this->createMock(SocketConfig::class);
        $socketConfigMock->method('get')->with('client')->willReturn('client.sock');

        $clientSocket = $this->getMockBuilder(ClientSocket::class)
            ->onlyMethods(['bind'])
            ->getMock();

        // Assert that bind is called with the correct path
        $clientSocket->expects($this->once())
            ->method('bind')
            ->with('client.sock');

        $clientSocket->__construct();
    }

    public function testClientSocketReceivesMessage()
    {
        $clientSocket = $this->getMockBuilder(ClientSocket::class)
            ->onlyMethods(['listen', 'message'])
            ->getMock();

        $clientSocket->method('listen')->willReturn($this->getClientSocketResponses());

        foreach ($clientSocket->listen() as $message) {
            $this->assertIsString($message);
        }
    }

    private function getClientSocketResponses(): Generator
    {
        yield 'Enter your message: ';
        yield 'Received response: Test message.';
    }
}
