<?php

declare(strict_types=1);

namespace Test\Command;

use Viking311\Chat\Command\ChatClient\ChatClient;
use Viking311\Chat\Command\ChatServer\ChatServer;
use Viking311\Chat\Command\CommandFactory;
use PHPUnit\Framework\TestCase;

class CommandFactoryTest extends TestCase
{
    public function testGetChatServer()
    {
        $factory = new CommandFactory();

        $cmd = $factory->getChatServer();

        $this->assertInstanceOf(ChatServer::class, $cmd);
    }

    public function testGetChatClient()
    {
        $factory = new CommandFactory();

        $cmd = $factory->getChatClient();

        $this->assertInstanceOf(ChatClient::class, $cmd);
    }
}
