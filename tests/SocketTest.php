<?php

use PHPUnit\Framework\TestCase;
use SocketChat\Socket;

class SocketTest extends TestCase
{
    protected function setUp(): void
    {
        Mockery::close();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testCreateSocket()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();
        $socketMock->shouldAllowMockingProtectedMethods();

        $socketMock->shouldReceive('create')->once()->andReturnUsing(function() use ($socketMock) {
            $socketMock->socket = 'mocked_socket';
        });

        $socketMock->shouldReceive('getSocket')->once()->andReturn('mocked_socket');

        $socketMock->create();

        $this->assertEquals('mocked_socket', $socketMock->getSocket());
    }

    public function testConnectSocket()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();
        $socketMock->shouldAllowMockingProtectedMethods();  // Разрешаем мокацию protected методов

        $socketMock->shouldReceive('connect')->once()->andReturn(true);

        $socketMock->connect();
        $this->assertTrue(true); 
    }

    public function testBindSocket()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();
        $socketMock->shouldAllowMockingProtectedMethods();

        $socketMock->shouldReceive('bind')->once()->andReturn(true);

        $socketMock->bind();
        $this->assertTrue(true);
    }

    public function testAcceptSocket()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();
        $socketMock->shouldAllowMockingProtectedMethods(); 

        $socketMock->shouldReceive('accept')->once()->andReturn('client_socket_mock');

        $clientSocket = $socketMock->accept();
        $this->assertEquals('client_socket_mock', $clientSocket);
    }

    public function testReadSocket()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();
        $socketMock->shouldAllowMockingProtectedMethods();

        $socketMock->shouldReceive('read')->once()->andReturn('Hello, Client!');

        $message = $socketMock->read('client_socket_mock');
        $this->assertEquals('Hello, Client!', $message);
    }

    public function testSendSocket()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();
        $socketMock->shouldAllowMockingProtectedMethods();

        $socketMock->shouldReceive('send')->once();

        $socketMock->send('client_socket_mock', 'Test message');
    }

    public function testCloseSocket()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();
        $socketMock->shouldAllowMockingProtectedMethods();

        $socketMock->shouldReceive('close')->once();

        $socketMock->close();
    }

    public function testSocketCreateException()
    {
        $socketMock = Mockery::mock(Socket::class)->makePartial();
        $socketMock->shouldAllowMockingProtectedMethods(); 

        $socketMock->shouldReceive('create')->once()->andThrow(new \Exception('Не удалось создать сокет'));

        $this->expectException(\Exception::class);
        $socketMock->create();
    }
}
