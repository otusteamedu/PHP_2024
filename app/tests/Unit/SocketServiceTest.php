<?php

namespace Tests\Unit;

use SlavaMakhov\OtusTestApp\SocketService;
use PHPUnit\Framework\TestCase;
use Exception;

class SocketServiceTest extends TestCase
{
    /** @var SocketService */
    private SocketService $socketService;

    /**
     * Метод устанавливает соедениене с классом SocketService
     *
     * @return void
     */
    protected function setUp(): void
    {
        $getConfig = parse_ini_file(__DIR__ . "/../../src/config.ini");
        $this->socketService = new SocketService($getConfig["socket_path"], $getConfig["socket_length"]);
    }

    /**
     * Тестирует создание сокета
     *
     * @throws Exception
     */
    public function testCreate()
    {
        $this->assertInstanceOf(SocketService::class, $this->socketService->create());
    }

    /**
     * Тестирует искючение для метода
     * создания сокета
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionCreate(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Socket create error");

        $this->socketService->create(true);
    }

    /**
     * Тестирует исключение привязки сокета
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionBind(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error to bind");

        $this->socketService->bind();
    }

    /**
     * Тестирует исключение слушателя сокета
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionListen(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error to listen");

        $this->socketService->listen();
    }

    /**
     * Тестирует исключение соединения клиента
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionAccept(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error to accept");

        $this->socketService->accept();
    }

    /**
     * Тестирует исключение соединения с сокетом
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionConnect(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error to connect");

        $this->socketService->socketConnect();
    }

    /**
     * Тестирует исключение отправки сообщения
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionSendMessage(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error send message");

        $this->socketService->sendMessage('test');
    }

    /**
     * Тестирует исключение закрытия сокета
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionClose(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error close session");

        $this->socketService->closeSession();
    }
}
