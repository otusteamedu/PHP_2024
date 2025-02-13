<?php

declare(strict_types=1);

namespace Tests\Unit;

use SlavaMakhov\OtusTestApp\Server;
use PHPUnit\Framework\TestCase;
use Exception;
use Generator;

class ServerTest extends TestCase
{
    /**
     * Тестирует метод получения сообщения
     *
     * @throws Exception
     */
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

        $serverMock->run(true);
    }

    /**
     * Метод генерирует сообщение
     *
     * @return Generator
     */
    public static function messageGenerator(): Generator
    {
        yield "test is work";
    }
}
