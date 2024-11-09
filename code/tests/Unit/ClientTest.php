<?php
namespace Tests\Unit;

use AlexAgapitov\OtusComposerProject\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $config = parse_ini_file(__DIR__ . "/../../src/config.ini");
        $this->client = new Client($config['file'], $config['length']);
    }

    public function testSuccessSendMessage()
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->onlyMethods(['getMessage', 'connect', 'sendMessage'])
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('connect')
            ->WillReturn(null);

        $clientMock->method('getMessage')
            ->WillReturn(self::messageGenerator());

        $clientMock->method('sendMessage')
            ->WillReturn(true);

        $this->expectOutputString('Отправленно сообщение: '. 'test message' . PHP_EOL);

        $clientMock->app(true);
    }

    public function testFailedSendMessage()
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->onlyMethods(['getMessage', 'connect', 'close', 'sendMessage'])
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('connect')
            ->WillReturn(null);

        $clientMock->method('close')
            ->WillReturn(null);

        $clientMock->method('getMessage')
            ->WillReturn(self::messageGenerator());

        $clientMock->method('sendMessage')
            ->WillReturn(false);

        $this->expectOutputString('Не удалось отправить сообщение. Сеанс завершен' . PHP_EOL);

        $clientMock->app(true);
    }

    public function testExceptionFailedSendMessage()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Error to connect");
        $this->client->connect();
    }

    public static function messageGenerator(): \Generator
    {
        yield "test message";
    }
}