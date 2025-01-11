<?php

use PHPUnit\Framework\TestCase;
use SocketChat\Client;
use SocketChat\Socket;

class ClientTest extends TestCase
{
    protected function setUp(): void
    {
        Mockery::close();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testRunClient()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();

        $socketMock->shouldAllowMockingProtectedMethods();

        $socketMock->shouldReceive('create')->once();
        $socketMock->shouldReceive('connect')->once();
        $socketMock->shouldReceive('send')->once();
        $socketMock->shouldReceive('read')->once()->andReturn('Message received');
        $socketMock->shouldReceive('close')->once();

        $clientMock = Mockery::mock(Client::class)->makePartial();
        $clientMock->shouldAllowMockingProtectedMethods();
        $clientMock->shouldReceive('getUserInput')->andReturn('Test message');

        $clientMock->shouldReceive('getSocket')->andReturn($socketMock);

        $clientMock->run();
    }
}
