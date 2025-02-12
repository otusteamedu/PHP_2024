<?php

declare(strict_types=1);

namespace Tests;

use Mockery;
use Otus\SocketChat\Client;
use Otus\SocketChat\Socket;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Client::class)]
class ClientTest extends TestCase
{
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

    protected function setUp(): void
    {
        Mockery::close();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
