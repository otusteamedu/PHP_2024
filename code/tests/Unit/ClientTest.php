<?php

declare(strict_types=1);

namespace PavelMiasnov\PhpSocketChat\Tests\Unit;

use Exception;
use PavelMiasnov\PhpSocketChat\Client;
use PavelMiasnov\PhpSocketChat\UnixSocket;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Client::class)]
#[UsesClass(UnixSocket::class)]
class ClientTest extends TestCase
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
     * Test Client construction with valid parameters.
     */
    public function testClientConstruction(): void
    {
        $client = new Client($this->host, $this->port, $this->length);
        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(UnixSocket::class, $client->client);
    }

    /**
     * Test app() with normal message flow and exit.
     */
    public function testAppSendsMessagesAndExits(): void
    {
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
        $client = new Client($this->host, $this->port, $this->length);
        $reflection = new \ReflectionProperty(Client::class, 'client');
        $reflection->setAccessible(true);
        $reflection->setValue($client, $socketMock);

        // Simulate input with callback
        $inputs = ["hello", "exit"];
        $inputProvider = function () use (&$inputs) {
            return array_shift($inputs) ?: "exit"; // Fallback to exit
        };

        // Run and verify output
        $this->expectOutputString("Input message\nInput message\nСеанс завершен \n");
        $client->app($inputProvider);
    }

    /**
     * Test app() with a single exit command.
     */
    public function testAppExitsImmediately(): void
    {
        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('socketConnect');
        $socketMock->expects($this->once())->method('sendMessage')->with('exit');
        $socketMock->expects($this->once())->method('closeSession');

        // Create Client and inject mock
        $client = new Client($this->host, $this->port, $this->length);
        $reflection = new \ReflectionProperty(Client::class, 'client');
        $reflection->setAccessible(true);
        $reflection->setValue($client, $socketMock);

        // Simulate immediate exit
        $inputs = ["exit"];
        $inputProvider = function () use (&$inputs) {
            return array_shift($inputs) ?: "exit";
        };

        // Run and verify output
        $this->expectOutputString("Input message\nСеанс завершен \n");
        $client->app($inputProvider);
    }

    /**
     * Test app() with empty input before exit.
     */
    public function testAppHandlesEmptyInput(): void
    {
        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('socketConnect');
        $socketMock->expects($this->exactly(2))->method('sendMessage')
            ->willReturnCallback(function ($msg) {
                static $callCount = 0;
                $expectedMessages = ["\n", 'exit'];
                $this->assertEquals($expectedMessages[$callCount], $msg);
                $callCount++;
            });
        $socketMock->expects($this->once())->method('closeSession');

        // Create Client and inject mock
        $client = new Client($this->host, $this->port, $this->length);
        $reflection = new \ReflectionProperty(Client::class, 'client');
        $reflection->setAccessible(true);
        $reflection->setValue($client, $socketMock);

        // Simulate empty input then exit
        $inputs = ["\n", "exit"];
        $inputProvider = function () use (&$inputs) {
            return array_shift($inputs) ?: "exit";
        };

        // Run and verify output
        $this->expectOutputString("Input message\nInput message\nСеанс завершен \n");
        $client->app($inputProvider);
    }

    /**
     * Test app() with whitespace input before exit.
     */
    public function testAppHandlesWhitespaceInput(): void
    {
        // Mock UnixSocket
        $socketMock = $this->createMock(UnixSocket::class);
        $socketMock->expects($this->once())->method('socketConnect');
        $socketMock->expects($this->exactly(2))->method('sendMessage')
            ->willReturnCallback(function ($msg) {
                static $callCount = 0;
                $expectedMessages = ["  \n", 'exit'];
                $this->assertEquals($expectedMessages[$callCount], $msg);
                $callCount++;
            });
        $socketMock->expects($this->once())->method('closeSession');

        // Create Client and inject mock
        $client = new Client($this->host, $this->port, $this->length);
        $reflection = new \ReflectionProperty(Client::class, 'client');
        $reflection->setAccessible(true);
        $reflection->setValue($client, $socketMock);

        // Simulate whitespace input then exit
        $inputs = ["  \n", "exit"];
        $inputProvider = function () use (&$inputs) {
            return array_shift($inputs) ?: "exit";
        };

        // Run and verify output
        $this->expectOutputString("Input message\nInput message\nСеанс завершен \n");
        $client->app($inputProvider);
    }
}
