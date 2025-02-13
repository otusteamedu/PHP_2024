<?php

declare(strict_types=1);

namespace Tests\Unit;

use SlavaMakhov\OtusTestApp\Client;
use PHPUnit\Framework\TestCase;
use Exception;
use Generator;

class ClientTest extends TestCase
{
    /** @var Client */
    private Client $client;

    /**
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        $getConfig = parse_ini_file(__DIR__ . "/../../src/config.ini");
        $this->client = new Client($getConfig["socket_path"], $getConfig["socket_length"]);
    }

    /**
     * Тестирует успешное отправление сообщения
     *
     * @return void
     *
     * @throws Exception
     */
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

        $this->expectOutputString('Отправленно сообщение: ' . 'test message' . PHP_EOL);

        $clientMock->run(true);
    }

    /**
     * Тестирует не успешное отправление сообщения
     *
     * @return void
     *
     * @throws Exception
     */
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

        $clientMock->run(true);
    }

    /**
     * Тестирует исключение при не успешной отправке сообщения
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionFailedSendMessage()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Error to connect");
        $this->client->connect();
    }

    /**
     * Метод генератор сообщения
     *
     * @return Generator
     */
    public static function messageGenerator(): Generator
    {
        yield "test message";
    }
}
