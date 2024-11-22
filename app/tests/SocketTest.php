<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Evgenyart\UnixSocketChat\Socket;
use Evgenyart\UnixSocketChat\Exceptions\SocketException;

class SocketTest extends TestCase
{
    private $socket;

    public function testSocketCreate()
    {
        $this->socket = new Socket(Constants::TEST_SOCKET_PATH);
        $create = $this->socket->create();
        $this->assertInstanceOf(Socket::class, $create);
    }

    public function testSocketBind()
    {
        $this->socket = new Socket(Constants::TEST_SOCKET_PATH);
        $resultBind = $this->socket->create()->bind();
        $this->assertInstanceOf(Socket::class, $resultBind);
    }

    public function testSockeListen()
    {
        $this->socket = new Socket(Constants::TEST_SOCKET_PATH);
        $resultListen = $this->socket->create()->bind()->listen();
        $this->assertInstanceOf(Socket::class, $resultListen);
    }

    public function testConstructException()
    {
        $this->expectException(SocketException::class);
        $this->expectExceptionMessage("Error socket path");
        $this->socket = new Socket('');
    }

    public function testSocketCreateException()
    {
        $this->socket = new Socket(Constants::TEST_SOCKET_PATH);
        $this->expectException(SocketException::class);
        $this->expectExceptionMessage("Unable to create");
        $this->socket->create(true);
    }

    public function testSocketBindException()
    {
        $this->socket = new Socket(Constants::TEST_SOCKET_PATH);
        $this->expectException(SocketException::class);
        $this->expectExceptionMessage("Unable to bind");
        $this->socket->create()->bind(true);
    }

    public function testSocketClose()
    {
        $this->socket = new Socket(Constants::TEST_SOCKET_PATH);
        $this->assertNull($this->socket->close());
    }

    public function testSocketListenException()
    {
        $this->socket = new Socket(Constants::TEST_SOCKET_PATH);
        $this->expectException(SocketException::class);
        $this->expectExceptionMessage("Unable to listen socket");
        $this->socket->create()->listen();
    }
}
