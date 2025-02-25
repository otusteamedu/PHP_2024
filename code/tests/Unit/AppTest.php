<?php

declare(strict_types=1);

namespace PavelMiasnov\PhpSocketChat\Tests\Unit;

use PavelMiasnov\PhpSocketChat\App;
use PavelMiasnov\PhpSocketChat\Client;
use PavelMiasnov\PhpSocketChat\Server;
use PavelMiasnov\PhpSocketChat\UnixSocket;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(App::class)]
#[UsesClass(Client::class)]
#[UsesClass(Server::class)]
#[UsesClass(UnixSocket::class)]
class AppTest extends TestCase
{
    private string $host = '/tmp/test.sock';
    private int $port = 0;
    private int $length = 2048;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app = new App();
    }

    public function testAppConstruction(): void
    {
        $this->assertInstanceOf(App::class, $this->app);
    }

    public function testRunWithInvalidMode(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Неверный аргумент. Доступны только `server` или `client`");

        $_SERVER['argv'][1] = 'invalid';
        $this->app->run();
    }

    public function testRunServerMode(): void
    {
        $unixSocketMock = $this->createMock(UnixSocket::class);
        $server = $this->getMockBuilder(Server::class)
            ->setConstructorArgs([$this->host, $this->port, $this->length])
            ->onlyMethods([])
            ->getMock();
        $server->server = $unixSocketMock;

        $app = $this->getMockBuilder(App::class)
            ->onlyMethods(['run'])
            ->getMock();

        $app->expects($this->once())
            ->method('run')
            ->willReturnCallback(function () use ($server) {
                $this->assertInstanceOf(Server::class, $server);
            });

        $_SERVER['argv'][1] = 'server';
        $app->run();
    }

    public function testRunClientMode(): void
    {
        $unixSocketMock = $this->createMock(UnixSocket::class);
        $client = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([$this->host, $this->port, $this->length])
            ->onlyMethods([])
            ->getMock();
        $client->client = $unixSocketMock;

        $app = $this->getMockBuilder(App::class)
            ->onlyMethods(['run'])
            ->getMock();

        $app->expects($this->once())
            ->method('run')
            ->willReturnCallback(function () use ($client) {
                $this->assertInstanceOf(Client::class, $client);
            });

        $_SERVER['argv'][1] = 'server';
        $app->run();
    }

    public function testRunServerModeExecutes(): void
    {
        $_SERVER['argv'][1] = 'server';

        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('bind');
        $socketMock->expects($this->once())->method('listen');
        $socketMock->expects($this->once())->method('accept');
        $socketMock->expects($this->once())->method('readMessage')->willReturn('exit');
        $socketMock->expects($this->once())->method('closeSession');

        // Create Server and inject mock
        $server = new Server('/tmp/test.sock', 0, 2048);
        $reflectionServer = new \ReflectionProperty(Server::class, 'server');
        $reflectionServer->setAccessible(true);
        $reflectionServer->setValue($server, $socketMock);

        // Create App and inject config
        $app = new App();
        $reflectionApp = new \ReflectionProperty(App::class, 'config');
        $reflectionApp->setAccessible(true);
        $reflectionApp->setValue($app, ['host' => '/tmp/test.sock', 'port' => 0, 'length' => 2048]);

        // Inject Server into App (requires refactoring App)
        $reflectionAppServer = new \ReflectionClass(App::class);
        $runMethod = $reflectionAppServer->getMethod('run');
        $runMethod->setAccessible(true);
        $runMethod->invoke($app, $server); // Pass mocked Server

        $this->expectOutputString("Клиент закончил сеанс \nSuccess end\n");
    }

    public function testRunClientModeExecutes(): void
    {
        $_SERVER['argv'][1] = 'client';

        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('socketConnect');
        $socketMock->expects($this->exactly(2))->method('sendMessage')
            ->willReturnCallback(function ($msg) {
                static $callCount = 0;
                $expectedMessages = ['hello', 'exit'];
                $this->assertEquals($expectedMessages[$callCount], $msg);
                $callCount++;
            });
        $socketMock->expects($this->once())->method('closeSession');

        // Create Client and inject mock
        $client = new Client('/tmp/test.sock', 0, 2048);
        $reflectionClient = new \ReflectionProperty(Client::class, 'client');
        $reflectionClient->setAccessible(true);
        $reflectionClient->setValue($client, $socketMock);

        // Create App and inject config
        $app = new App();
        $reflectionApp = new \ReflectionProperty(App::class, 'config');
        $reflectionApp->setAccessible(true);
        $reflectionApp->setValue($app, ['host' => '/tmp/test.sock', 'port' => 0, 'length' => 2048]);

        // Simulate input with callback
        $inputs = ["hello", "exit"];
        $inputProvider = function () use (&$inputs) {
            return array_shift($inputs) ?: "exit"; // Fallback to exit if empty
        };

        // Run with injected input provider
        $reflectionMethod = new \ReflectionMethod(Client::class, 'app');
        $reflectionMethod->invoke($client, $inputProvider);

        $this->expectOutputString("Input message\nInput message\nСеанс завершен \n");
    }

    public function testConstructionWithInvalidConfig(): void
    {
        // Temporarily rename config.ini or mock parse_ini_file
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/Configuration file.*not found/');

        $original = __DIR__ . '/../../src/config.ini';
        rename($original, $original . '.bak');

        try {
            new App();
        } finally {
            rename($original . '.bak', $original);
        }
    }
}
