<?php

namespace Test\Socket;

use Viking311\Chat\Socket\Socket;
use PHPUnit\Framework\TestCase;
use Viking311\Chat\Socket\SocketException;

class SocketTest extends TestCase
{
    /**
     * @return void
     * @throws SocketException
     */
    public function testCreateSocket()
    {
        $socket = new Socket('php://memory');

        $actual = $socket->create();

        $this->assertNotNull($socket->socket);
        $this->assertInstanceOf(Socket::class, $actual);
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function testSocketBindFileNotExists()
    {
        $file = '/tmp/socket_test.sock';
        unlink($file);
        $socket = new Socket($file);
        $actual = $socket
            ->create()
            ->bind();

        $this->assertInstanceOf(Socket::class, $actual);
        $this->assertFileExists($file);

        unlink($file);
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function testSocketBindFileExistsResetFalse()
    {
        $file = '/tmp/socket_test.sock';
        file_put_contents($file, '');
        $socket = new Socket($file);
        $this->expectException(SocketException::class);

        $socket
            ->create()
            ->bind(false);

        unlink($file);
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function testSocketBindFileExistsResetTrue()
    {
        $file = '/tmp/socket_test.sock';
        file_put_contents($file, '');
        $socket = new Socket($file);

        $actual = $socket
            ->create()
            ->bind(true);

        $this->assertInstanceOf(Socket::class, $actual);
        $this->assertFileExists($file);

        unlink($file);
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function testSocketListenSuccess()
    {
        $file = '/tmp/socket_test.sock';
        $socket = new Socket($file);

        $actual = $socket
            ->create()
            ->bind(true)
            ->listen();

        $this->assertInstanceOf(Socket::class, $actual);

        unlink($file);
    }

    public function testSocketListenException()
    {
        $file = '/tmp/socket_test.sock';
        $socket = new Socket($file);

        $this->expectException(SocketException::class);

        $socket
            ->create()
            ->listen();
    }
}
