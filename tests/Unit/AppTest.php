<?php

namespace Tests\Unit;

use App\Core\App;
use App\Sockets\ClientSocket;
use App\Sockets\ServerSocket;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function setUp(): void
    {
        global $argv;
        $argv = [];
    }

    public function testRunThrowsExceptionWhenNoContextProvided()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("No context specified. Use 'server' or 'client'!");

        $app = new App();
        iterator_to_array($app->run());
    }

    public function testRunThrowsExceptionWhenInvalidContextProvided()
    {
        global $argv;
        $argv[1] = 'invalid';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid context specified. Use 'server' or 'client'!");

        $app = new App();
        iterator_to_array($app->run());
    }

    public function testRunCallsServerSocket()
    {
        global $argv;
        $argv[1] = 'server';

        $serverSocketMock = $this->createMock(ServerSocket::class);
        $serverSocketMock->method('listen')->willReturn($this->getSampleServerResponses());

        $this->getMockBuilder(App::class)
            ->onlyMethods(['run'])
            ->getMock();

        foreach ($serverSocketMock->listen() as $output) {
            $this->assertSame("Server listening...\n", $output);
        }
    }

    public function testRunCallsClientSocket()
    {
        global $argv;
        $argv[1] = 'client';

        $clientSocketMock = $this->createMock(ClientSocket::class);
        $clientSocketMock->method('listen')->willReturn($this->getSampleClientResponses());

        $this->getMockBuilder(App::class)
            ->onlyMethods(['run'])
            ->getMock();

        foreach ($clientSocketMock->listen() as $output) {
            $this->assertSame("Client listening...\n", $output);
        }
    }

    private function getSampleServerResponses(): Generator
    {
        yield "Server listening...\n";
    }

    private function getSampleClientResponses(): Generator
    {
        yield "Client listening...\n";
    }
}
