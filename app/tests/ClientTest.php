<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Evgenyart\UnixSocketChat\Client;
use Test\Constants;

class ClientTest extends TestCase
{
    public function testStartClient()
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        $clientMock = $this->getMockBuilder(Client::class)
            ->onlyMethods(['sendReadline', 'connection'])
            ->setConstructorArgs([Constants::TEST_SOCKET_PATH])
            ->getMock();

        $clientMock->method('sendReadline')
            ->willReturn('stop');

        $clientMock->method('connection')
            ->willReturn($socket);

        $clientMock->start();

        $this->expectOutputString('Client starting');
    }

    public function testReadline()
    {
        $client = new Client(Constants::TEST_SOCKET_PATH);
        $resClient = $client->sendReadline(true);
        $this->assertSame('stop', $resClient);
    }
}
