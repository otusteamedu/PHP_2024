<?php
namespace Tests\Unit;

use AlexAgapitov\OtusComposerProject\App;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    private App $app;

    protected function setUp(): void
    {
        $this->app = new App();
    }

    public function testExceptionEmptyArgs()
    {
        $_SERVER['argv'] = "";
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Не введен параметр запуска");
        $this->app->run();
    }

    public function testExceptionBagArgs()
    {
        $_SERVER['argv'] = ["app.php", "servver"];
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Неверный аргумент: `server` для старта сервера или `client` для старта клиента");
        $this->app->run();
    }

    public function testStartServer()
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