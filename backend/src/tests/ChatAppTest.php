<?php

declare(strict_types=1);

namespace TBublikova\Php2024\tests;

use PHPUnit\Framework\TestCase;
use TBublikova\Php2024\ChatApp;
use TBublikova\Php2024\Socket;
use TBublikova\Php2024\ServerChat;
use TBublikova\Php2024\ClientChat;

class ChatAppTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $_SERVER['argv'] = ['app.php'];
    }

    public function testInvalidArguments(): void
    {
        $_SERVER['argv'][] = 'invalid_mode';

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Incorrect arguments. Use: php app.php [server|client]');

        new ChatApp();
    }

    public function testValidArgumentsServer(): void
    {
        $_SERVER['argv'][] = 'server';

        $chatApp = new ChatApp();

        $reflection = new \ReflectionClass($chatApp);
        $sideProperty = $reflection->getProperty('side');
        $sideProperty->setAccessible(true);

        $this->assertEquals('server', $sideProperty->getValue($chatApp));
    }


    public function testServerModeInitialization(): void
    {
        $_SERVER['argv'][] = 'server';

        $socketMock = $this->createMock(Socket::class);
        $serverChatMock = $this->createMock(ServerChat::class);

        $chatApp = new ChatApp();

        $this->assertInstanceOf(ServerChat::class, new ServerChat($socketMock));
    }

    public function testClientModeInitialization(): void
    {
        $_SERVER['argv'][] = 'client';

        $socketMock = $this->createMock(Socket::class);
        $clientChatMock = $this->createMock(ClientChat::class);

        $chatApp = new ChatApp();

        $this->assertInstanceOf(ClientChat::class, new ClientChat($socketMock));
    }
}
