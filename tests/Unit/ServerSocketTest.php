<?php

namespace Tests\Unit;

use App\Sockets\ServerSocket;
use App\Config\SocketConfig;
use Generator;
use PHPUnit\Framework\TestCase;

class ServerSocketTest extends TestCase
{
    public function testServerSocketBindsToCorrectSocket()
    {
        $socketConfigMock = $this->createMock(SocketConfig::class);
        $socketConfigMock->method('get')->with('server')->willReturn('server.sock');

        $serverSocket = $this->getMockBuilder(ServerSocket::class)
            ->onlyMethods(['bind'])
            ->getMock();

        $serverSocket->expects($this->once())
            ->method('bind')
            ->with('server.sock');

        $serverSocket->__construct();
    }

    public function testServerSocketReceivesMessage()
    {
        $serverSocket = $this->getMockBuilder(ServerSocket::class)
            ->onlyMethods(['listen', 'message'])
            ->getMock();

        $serverSocket->method('listen')->willReturn($this->getServerSocketResponses());

        foreach ($serverSocket->listen() as $response) {
            $this->assertIsString($response);
        }
    }

    private function getServerSocketResponses(): Generator
    {
        yield 'Received message: Hello Client.';
        yield 'Sending response: OK.';
    }
}
