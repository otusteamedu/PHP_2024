<?php

declare(strict_types=1);

namespace Tests;

use Mockery;
use Otus\SocketChat\Server;
use Otus\SocketChat\Socket;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Server::class)]
class ServerTest extends TestCase
{
    protected function setUp(): void
    {
        Mockery::close();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testRunServer()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();

        $socketMock->shouldAllowMockingProtectedMethods();

        $socketMock->shouldReceive('create')->once();
        $socketMock->shouldReceive('bind')->once();
        $socketMock->shouldReceive('listen')->once();
        $socketMock->shouldReceive('accept')->once()->andReturn('clientSocket');
        $socketMock->shouldReceive('read')->once()->andReturn('Message from client');
        $socketMock->shouldReceive('send')->once();
        $socketMock->shouldReceive('close')->once();

        $serverMock = Mockery::mock(Server::class)->makePartial();
        $serverMock->shouldAllowMockingProtectedMethods();
        $serverMock->shouldReceive('getSocket')->andReturn($socketMock);

        $serverMock->run();
    }
}
