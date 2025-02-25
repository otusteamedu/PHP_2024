<?php

declare(strict_types=1);

namespace PavelMiasnov\PhpSocketChat\Tests\Unit;

use Exception;
use PavelMiasnov\PhpSocketChat\UnixSocket;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UnixSocket::class)]
class UnixSocketTest extends TestCase
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
     * Test successful construction.
     */
    public function testSocketCreationSuccess(): void
    {
        $socket = new UnixSocket($this->host, $this->port, $this->length);
        $this->assertInstanceOf(UnixSocket::class, $socket);
        $this->assertInstanceOf(\Socket::class, $socket->socket); // Check for Socket object
        $this->assertNull($socket->client);
    }

    /**
     * Test bind() success.
     */
    public function testBindSuccess(): void
    {
        $socket = new UnixSocket($this->host, $this->port, $this->length);
        $socket->bind();
        $this->assertFileExists($this->host); // Socket file created
    }

    /**
     * Test bind() failure (e.g., address in use).
     */
    public function testBindFailure(): void
    {
        $socket1 = new UnixSocket($this->host, $this->port, $this->length);
        $socket1->bind(); // Occupy the address

        $socket2 = new UnixSocket($this->host, $this->port, $this->length);
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Failed to bind socket/');
        $socket2->bind();
    }

    /**
     * Test listen() success.
     */
    public function testListenSuccess(): void
    {
        $socket = new UnixSocket($this->host, $this->port, $this->length);
        $socket->bind();
        $socket->listen();
        $this->assertTrue(true); // No exception means success
    }

    /**
     * Test socketConnect() success.
     */
    public function testSocketConnectSuccess(): void
    {
        // Start a server to connect to
        $serverSocket = new UnixSocket($this->host, $this->port, $this->length);
        $serverSocket->bind();
        $serverSocket->listen();

        $clientSocket = new UnixSocket($this->host, $this->port, $this->length);
        $clientSocket->socketConnect();
        $this->assertTrue(true); // No exception means success
    }

    /**
     * Test socketConnect() failure (no server).
     */
    public function testSocketConnectFailure(): void
    {
        $socket = new UnixSocket($this->host, $this->port, $this->length);
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Failed to connect socket/');
        $socket->socketConnect();
    }

    /**
     * Test accept() and sendMessage/readMessage success.
     */
    public function testAcceptSendAndReadMessageSuccess(): void
    {
        $serverSocket = new UnixSocket($this->host, $this->port, $this->length);
        $serverSocket->bind();
        $serverSocket->listen();

        $clientSocket = new UnixSocket($this->host, $this->port, $this->length);
        $clientSocket->socketConnect();

        $serverSocket->accept();
        $clientSocket->sendMessage("Test message\n");
        $received = $serverSocket->readMessage();

        $this->assertEquals("Test message\n", $received);
    }

    /**
     * Test readMessage() with no client.
     */
    public function testReadMessageNoClient(): void
    {
        $socket = new UnixSocket($this->host, $this->port, $this->length);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("No client connection established");
        $socket->readMessage();
    }

    /**
     * Test sendMessage() failure (not connected).
     */
    public function testSendMessageFailure(): void
    {
        $socket = new UnixSocket($this->host, $this->port, $this->length);
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Failed to send message/');
        $socket->sendMessage("Test");
    }

    /**
     * Test closeSession() with both socket and client.
     */
    public function testCloseSessionWithClient(): void
    {
        $serverSocket = new UnixSocket($this->host, $this->port, $this->length);
        $serverSocket->bind();
        $serverSocket->listen();

        $clientSocket = new UnixSocket($this->host, $this->port, $this->length);
        $clientSocket->socketConnect();

        $serverSocket->accept();
        $serverSocket->closeSession();

        $this->assertFalse(is_resource($serverSocket->socket));
        $this->assertFalse(is_resource($serverSocket->client));
    }

    /**
     * Test closeSession() with only socket.
     */
    public function testCloseSessionWithoutClient(): void
    {
        $socket = new UnixSocket($this->host, $this->port, $this->length);
        $socket->closeSession();
        $this->assertFalse(is_resource($socket->socket));
        $this->assertNull($socket->client);
    }
}
