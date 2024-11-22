<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Evgenyart\UnixSocketChat\App;
use Evgenyart\UnixSocketChat\Client;
use Evgenyart\UnixSocketChat\Exceptions\AppException;

class AppTest extends TestCase
{
    private $app;

    protected function setUp(): void
    {
        $this->app = new App();

        if (file_exists(Constants::TEST_SOCKET_PATH)) {
            unlink(Constants::TEST_SOCKET_PATH);
        }
    }

    public function testExceptionEmptyParam()
    {
        $_SERVER['argv'] = "";
        $this->expectException(AppException::class);
        $this->expectExceptionMessage("Не введен параметр запуска (ожидается `start-server` либо `start-client`)");
        $this->app->run();
    }

    public function testExceptionUnallowedParam()
    {
        $_SERVER['argv'] = ["app.php", "test"];
        $this->expectException(AppException::class);
        $this->expectExceptionMessage("Неизвестный параметр. Ожидается `start-server` либо `start-client`");
        $this->app->run();
    }

    public function testConstructor()
    {
        $relay = $this->reflectionSetSocketPath();
        self::assertEquals(Constants::TEST_FAKE_SOCKET_PATH, $relay->getSocketPath());
    }

    public function testStartClient()
    {
        $_SERVER['argv'] = ["app.php", "start-client"];

        $appMock = $this->getMockBuilder(App::class)
            ->onlyMethods(['startClient'])
            ->disableOriginalConstructor()
            ->getMock();

        $appMock->method('startClient')
            ->WillReturn(null);

        $appMock->run();

        $this->expectOutputString('Client is running');
    }

    public function testStartServer()
    {
        $_SERVER['argv'] = ["app.php", "start-server"];

        $appMock = $this->getMockBuilder(App::class)
            ->onlyMethods(['startServer'])
            ->disableOriginalConstructor()
            ->getMock();

        $appMock->method('startServer')
            ->WillReturn(null);

        $appMock->run();

        $this->expectOutputString('Server is running');
    }

    private function reflectionSetSocketPath()
    {
        $reflectionClass = new \ReflectionClass(App::class);
        $reflectionProperty = $reflectionClass->getProperty('socketPath');
        $reflectionProperty->setAccessible(true);

        $relay = $reflectionClass->newInstanceWithoutConstructor();
        $reflectionProperty->setValue($relay, Constants::TEST_FAKE_SOCKET_PATH);

        return $relay;
    }
}
