<?php

declare(strict_types=1);

namespace PavelMiasnov\PhpSocketChat\Tests\Unit;

use Exception;
use PavelMiasnov\PhpSocketChat\Server;
use PavelMiasnov\PhpSocketChat\UnixSocket;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Server::class)]
#[UsesClass(UnixSocket::class)]
class ServerTest extends TestCase
{
    private string $host = '/tmp/test.sock';
    private int $port = 0;
    private int $length = 2048;

    protected function tearDown(): void
    {
        if (file_exists($this->host)) {
            unlink($this->host);
        }
    }

    /**
     * Test Server construction with no existing socket file.
     */
    public function testServerConstructionWithoutExistingFile(): void
    {
        if (file_exists($this->host)) {
            unlink($this->host);
        }
        $server = new Server($this->host, $this->port, $this->length);
        $this->assertInstanceOf(Server::class, $server);
        $this->assertInstanceOf(UnixSocket::class, $server->server);
    }

    /**
     * Test Server construction with an existing socket file (cleanup).
     */
    public function testServerConstructionWithExistingFile(): void
    {
        file_put_contents($this->host, '');
        $this->assertFileExists($this->host);
        $server = new Server($this->host, $this->port, $this->length);
        $this->assertInstanceOf(Server::class, $server);
        $this->assertFileDoesNotExist($this->host);
    }

    /**
     * Test app() with normal message flow and exit.
     */
    public function testAppReceivesMessagesAndExits(): void
    {
        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('bind');
        $socketMock->expects($this->once())->method('listen');
        $socketMock->expects($this->once())->method('accept');
        $socketMock->expects($this->exactly(2))->method('readMessage')
            ->willReturnOnConsecutiveCalls('Hello world', 'exit');
        $socketMock->expects($this->once())->method('closeSession');

        // Create Server and inject mock
        $server = new Server($this->host, $this->port, $this->length);
        $reflection = new \ReflectionProperty(Server::class, 'server');
        $reflection->setAccessible(true);
        $reflection->setValue($server, $socketMock);

        // Run and verify output
        $this->expectOutputString("Новое сообщение: Hello worldКлиент закончил сеанс \nSuccess end\n");
        $server->app();
    }

    /**
     * Test app() with immediate exit.
     */
    public function testAppExitsImmediately(): void
    {
        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('bind');
        $socketMock->expects($this->once())->method('listen');
        $socketMock->expects($this->once())->method('accept');
        $socketMock->expects($this->once())->method('readMessage')->willReturn('exit');
        $socketMock->expects($this->once())->method('closeSession');

        // Create Server and inject mock
        $server = new Server($this->host, $this->port, $this->length);
        $reflection = new \ReflectionProperty(Server::class, 'server');
        $reflection->setAccessible(true);
        $reflection->setValue($server, $socketMock);

        // Run and verify output
        $this->expectOutputString("Клиент закончил сеанс \nSuccess end\n");
        $server->app();
    }

    /**
     * Test app() with empty message before exit.
     */
    public function testAppHandlesEmptyMessage(): void
    {
        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('bind');
        $socketMock->expects($this->once())->method('listen');
        $socketMock->expects($this->once())->method('accept');
        $socketMock->expects($this->exactly(2))->method('readMessage')
            ->willReturnOnConsecutiveCalls("\n", 'exit');
        $socketMock->expects($this->once())->method('closeSession');

        // Create Server and inject mock
        $server = new Server($this->host, $this->port, $this->length);
        $reflection = new \ReflectionProperty(Server::class, 'server');
        $reflection->setAccessible(true);
        $reflection->setValue($server, $socketMock);

        // Run and verify output
        $this->expectOutputString("Новое сообщение: \nКлиент закончил сеанс \nSuccess end\n");
        $server->app();
    }

    /**
     * Test app() throws exception on read failure.
     */
    public function testAppThrowsOnReadFailure(): void
    {
        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('bind');
        $socketMock->expects($this->once())->method('listen');
        $socketMock->expects($this->once())->method('accept');
        $socketMock->expects($this->once())->method('readMessage')
            ->willThrowException(new Exception("Failed to read message: Some error\n"));

        // Create Server and inject mock
        $server = new Server($this->host, $this->port, $this->length);
        $reflection = new \ReflectionProperty(Server::class, 'server');
        $reflection->setAccessible(true);
        $reflection->setValue($server, $socketMock);

        // Expect exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Не удалось прочитать соообщение");
        $server->app();
    }

    /**
     * Test app() handles bind failure.
     */
    public function testAppHandlesBindFailure(): void
    {
        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('bind')
            ->willThrowException(new Exception("Bind failed"));

        // Create Server and inject mock
        $server = new Server($this->host, $this->port, $this->length);
        $reflection = new \ReflectionProperty(Server::class, 'server');
        $reflection->setAccessible(true);
        $reflection->setValue($server, $socketMock);

        // Expect exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Bind failed");
        $server->app();
    }
}
