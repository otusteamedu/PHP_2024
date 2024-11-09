<?php
namespace Tests\Unit;

use AlexAgapitov\OtusComposerProject\Server;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{
    public function testGetUserMessage()
    {
        $serverMock = $this->getMockBuilder(Server::class)
            ->onlyMethods(['getMessage', 'connect', 'close'])
            ->disableOriginalConstructor()
            ->getMock();

        $serverMock->method('close')
            ->WillReturn(null);

        $serverMock->method('connect')
            ->WillReturn(null);

        $serverMock->method('getMessage')
            ->WillReturn(self::messageGenerator());

        $this->expectOutputString('Пользователь прислал сообщение: test is work');

        $serverMock->app(true);
    }
    public static function messageGenerator(): \Generator
    {
        yield "test is work";
    }
}