<?php

namespace Tests\Unit;

use AlexAgapitov\OtusComposerProject\UnixSocket;
use PHPUnit\Framework\TestCase;

class UnixSocketTest extends TestCase
{
    private $unixSocket;
    private $config;
    protected function setUp(): void
    {
        $this->config = parse_ini_file(__DIR__ . "/../../src/config.ini");
        $this->unixSocket = new UnixSocket($this->config['file'], $this->config['length']);
    }

    public function testCreate()
    {
        $this->assertInstanceOf(UnixSocket::class, $this->unixSocket->create());
    }

    public function testExceptionCreate()
    {
        $this->exceptionMessageBind("Socket create error");
        $this->unixSocket->create(true);
    }

    public function testExceptionBind()
    {
        $this->exceptionMessageBind("Error to bind");
        $this->unixSocket->bind();
    }

    public function testExceptionListen()
    {
        $this->exceptionMessageBind("Error to listen");
        $this->unixSocket->listen();
    }

    public function testExceptionAccept()
    {
        $this->exceptionMessageBind("Error to accept");
        $this->unixSocket->accept();
    }

    public function testExceptionConnect()
    {
        $this->exceptionMessageBind("Error to connect");
        $this->unixSocket->socketConnect();
    }

    public function testExceptionSendMessage()
    {
        $this->exceptionMessageBind("Error send message");
        $this->unixSocket->sendMessage('test');
    }

    public function testExceptionClose()
    {
        $this->exceptionMessageBind("Error close session");
        $this->unixSocket->closeSession();
    }
    private function exceptionMessageBind(string $message) {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($message);
    }
}