<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Evgenyart\UnixSocketChat\Server;
use Evgenyart\UnixSocketChat\Exceptions\SocketException;
use Test\Constants;

class ServerTest extends TestCase
{
    public function testStartServer()
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        $serverMock = $this->getMockBuilder(Server::class)
            ->onlyMethods(['connection', 'read'])
            ->setConstructorArgs([Constants::TEST_SOCKET_PATH])
            ->getMock();

        $serverMock->method('connection')
            ->willReturn($socket);

        $serverMock->method('read')
            ->willReturn('test');

        $this->expectOutputString('Client sent message: test' . PHP_EOL);

        $serverMock->start(true);
    }

    public function testStartServerException()
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        $serverMock = $this->getMockBuilder(Server::class)
            ->onlyMethods(['connection'])
            ->setConstructorArgs([Constants::TEST_SOCKET_PATH])
            ->getMock();

        $serverMock->method('connection')
            ->willReturn($socket);

        $this->expectException(SocketException::class);
        $this->expectExceptionMessage("Error read message from socket");

        $serverMock->start();
    }
}
