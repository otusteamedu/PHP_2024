<?php

declare(strict_types=1);

namespace Tests\Unit;

use SlavaMakhov\OtusTestApp\App;
use PHPUnit\Framework\TestCase;
use Exception;

class AppTest extends TestCase
{
    /** @var App */
    private App $app;

    /**
     * Метод устанавливает соедениене с классом App
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->app = new App();
    }

    /**
     * Тестирует искючение если не указаны
     * параметры запуска
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionEmptyArgs(): void
    {
        $_SERVER['argv'] = "";

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Launch start not transmitted!");

        $this->app->run();
    }

    /**
     * Тестирует искючение если указан
     * аргумент с ошибкой
     *
     * @return void
     * @throws Exception
     */
    public function testExceptionBagArgs(): void
    {
        $_SERVER['argv'] = ["app.php", "cclientt"];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Enter one of the options: server or client" . PHP_EOL);

        $this->app->run();
    }

    /**
     * Тестирует старт Сервера
     *
     * @return void
     * @throws Exception
     */
    public function testStartServer(): void
    {
        $_SERVER['argv'] = ["app.php", "server"];

        $appMock = $this->getMockBuilder(App::class)
            ->onlyMethods(['startServer'])
            ->disableOriginalConstructor()
            ->getMock();

        $appMock->method('startServer')
            ->WillReturn(null);

        $appMock->run();

        $this->expectOutputString('Server start');
    }

    /**
     * Тестирует старт Клиента
     *
     * @return void
     * @throws Exception
     */
    public function testStartClient()
    {
        $_SERVER['argv'] = ["app.php", "client"];
        $appMock = $this->getMockBuilder(App::class)
            ->onlyMethods(['startClient'])
            ->disableOriginalConstructor()
            ->getMock();

        $appMock->method('startClient')
            ->WillReturn(null);

        $appMock->run();

        $this->expectOutputString('Client start');
    }
}
