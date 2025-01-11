<?php

use PHPUnit\Framework\TestCase;
use SocketChat\App;

class AppTest extends TestCase
{
    public function testRunServerMode()
    {
        $_SERVER['argv'] = ["app.php", "server"];
        $appMock = $this->getMockBuilder(App::class)
            ->onlyMethods(['runServer'])
            ->getMock();

        $appMock->expects($this->once())
            ->method('runServer');

        $appMock->run();
    }

    public function testRunClientMode()
    {
        $_SERVER['argv'] = ["app.php", "client"];
        $appMock = $this->getMockBuilder(App::class)
            ->onlyMethods(['runClient'])
            ->getMock();

        $appMock->expects($this->once())
            ->method('runClient');

        $appMock->run();
    }

    public function testRunInvalidMode()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Не найден режим "invalid"');

        $_SERVER['argv'] = ['app.php', 'invalid'];
        $app = new App();
        $app->run();
    }
}
