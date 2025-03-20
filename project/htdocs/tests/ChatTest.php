<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/ChatServer.php';
require_once __DIR__ . '/TestConnection.php'; // Подключаем тестовый класс

use App\ChatServer;
use PHPUnit\Framework\TestCase;
use Tests\TestConnection;

class ChatTest extends TestCase
{
    protected $chatServer;
    protected $mockClients = [];

    protected function setUp(): void
    {
        // Инициализируем сервер
        $this->chatServer = new ChatServer();

        // Создаем тестовые клиенты
        for ($i = 0; $i < 2; $i++) {
            $mockClient = new TestConnection();
            $mockClient->resourceId = $i + 1; // Добавляем свойство resourceId

            $this->mockClients[] = $mockClient;
        }
    }

    public function testOnOpenAddsClient()
    {
        // Проверяем, что клиент добавляется при подключении
        $client = $this->mockClients[0];
        $this->chatServer->onOpen($client);

        $this->assertCount(1, $this->chatServer->clients);
    }

    public function testOnCloseRemovesClient()
    {
        // Проверяем, что клиент удаляется при отключении
        $client = $this->mockClients[0];
        $this->chatServer->onOpen($client);
        $this->chatServer->onClose($client);

        $this->assertCount(0, $this->chatServer->clients);
    }

    public function testBroadcastMessageToAllClients()
    {
        // Проверяем, что сообщение отправляется всем клиентам
        $client1 = $this->mockClients[0];
        $client2 = $this->mockClients[1];

        $this->chatServer->onOpen($client1);
        $this->chatServer->onOpen($client2);

        $this->chatServer->onMessage($client1, json_encode([
            'type' => 'message',
            'sender' => 'TestUser',
            'message' => 'Hello!'
        ]));

        // Проверяем, что сообщение отправлено первому клиенту
        $this->assertContains(
            json_encode([
                'type' => 'message',
                'sender' => 'TestUser',
                'message' => 'Hello!'
            ]),
            $client1->sentData
        );

        // Проверяем, что сообщение отправлено второму клиенту
        $this->assertContains(
            json_encode([
                'type' => 'message',
                'sender' => 'TestUser',
                'message' => 'Hello!'
            ]),
            $client2->sentData
        );
    }
}