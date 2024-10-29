<?php
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase {
    public function testClientServerCommunication() {
        $client = new Client();
        $server = new Server();

        $client->run(); 
        $output = $server->run(); 

        $this->assertEquals("Получено сообщение: Hello!", $output);
    }

    public function testDockerComposeSetup() {
        // Проверка, что docker-compose.yml правильно настроен и приложение запускается корректно
        $output = shell_exec('docker-compose up -d');
        $this->assertStringContainsString("Starting", $output);

        //Проверка на соединение
        $clientResponse = shell_exec('docker exec client-container php client/app.php');
        $this->assertStringContainsString("Ответ от сервера", $clientResponse);
    }
}
