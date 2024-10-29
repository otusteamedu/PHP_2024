<?php
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase {
    private $server; 

    protected function setUp(): void {
        $this->server = new Server();
    }

    public function testCreateSocketSuccess() {
        $reflection = new ReflectionClass($this->server);
        $method = $reflection->getMethod('createSocket');
        $method->setAccessible(true);

        $this->assertNotNull($method->invoke($this->server));
    }

    public function testRunSocketCommunication() {
        $this->server = $this->createMock(Server::class);

        $this->server->method('run')
                     ->willReturn("Получено сообщение: Hello!");

        $this->expectOutputString("Получено сообщение: Hello!");
        $this->server->run();
    }
}
