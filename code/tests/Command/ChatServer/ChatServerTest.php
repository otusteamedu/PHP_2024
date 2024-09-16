<?php

namespace Test\Command\ChatServer;

use PHPUnit\Framework\MockObject\Exception;
use Test\Stubs\ReaderStub;
use Test\Stubs\WriterStub;
use Viking311\Chat\Command\ChatServer\ChatServer;
use PHPUnit\Framework\TestCase;
use Viking311\Chat\Socket\Socket;
use Viking311\Chat\Socket\SocketException;

class ChatServerTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     * @throws SocketException
     */
    public function testExecute()
    {
        $message = 'message';
        $socket = $this->createMock(Socket::class);
        $socket->method('read')->willReturn(
            $message

        );
        $socket
            ->expects(self::exactly(1))
            ->method('read');
        $socket
            ->expects(self::exactly(1))
            ->method('write')
            ->with('Received ' . strlen($message) .' bytes');
        $writer = new WriterStub();
        $chatServer = new ChatServer(
          $socket,
          $writer
        );
        $reflect = new \ReflectionClass($chatServer);
        $prop = $reflect->getProperty('infinityLoop');
        $prop->setValue($chatServer, false);

        $chatServer->execute();

        $expectedOutput = [
            'Server started' . PHP_EOL,
            'Received message from client: '. $message . PHP_EOL,
        ];
        $this->assertEquals(
            $expectedOutput,
            $writer->getBuffer()
        );
    }
}
