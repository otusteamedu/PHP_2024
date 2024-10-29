<?php
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {
    private $client;

    protected function setUp(): void {
        $this->client = new Client();
    }

    public function testCreateSocketSuccess() {
        
        $reflection = new ReflectionClass($this->client);
        $method = $reflection->getMethod('createSocket');
        $method->setAccessible(true);

        $this->assertNotNull($method->invoke($this->client));
    }

    public function testRunSocketCommunication() {
        $this->client = $this->createMock(Client::class);

        
        $this->client->method('run')
                     ->willReturn("Ответ от сервера");

        $this->expectOutputString("Ответ от сервера");
        $this->client->run();
    }
}
