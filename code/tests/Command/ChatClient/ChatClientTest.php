<?php

declare(strict_types=1);

namespace Test\Command\ChatClient;

use PHPUnit\Framework\MockObject\Exception;
use Test\Command\ChatClient\Stubs\ReaderStub;
use Test\Command\ChatClient\Stubs\WriterStub;
use Viking311\Chat\Command\ChatClient\ChatClient;
use PHPUnit\Framework\TestCase;
use Viking311\Chat\Socket\Socket;
use Viking311\Chat\Socket\SocketException;

class ChatClientTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     * @throws SocketException
     */
    public function testExecution()
    {
        $socket = $this->createMock(Socket::class);
        $socket->method('read')->willReturn(
            'message1',
            'message2'
        );
        $socket->expects(self::exactly(2))->method('read');
        $reader = new ReaderStub();
        $writer = new WriterStub();
        $client = new ChatClient(
            $socket,
            $reader,
            $writer
        );

        $client->execute();

        $expected = [
            'Client started' . PHP_EOL,
            'Server response: message1' . PHP_EOL,
            'Server response: message2' . PHP_EOL
        ];

        $this->assertEquals($expected, $writer->getBuffer());
    }
}
