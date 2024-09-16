<?php

declare(strict_types=1);

namespace Test\Application;

use PHPUnit\Framework\MockObject\Exception;
use Viking311\Chat\Application\Application;
use PHPUnit\Framework\TestCase;
use Viking311\Chat\Application\ApplicationException;
use Viking311\Chat\Command\ChatClient\ChatClient;
use Viking311\Chat\Command\ChatServer\ChatServer;
use Viking311\Chat\Command\CommandFactory;
use Viking311\Chat\Socket\SocketException;

class ApplicationTest extends TestCase
{
    /**
     * @return void
     * @throws ApplicationException
     * @throws Exception
     * @throws SocketException
     */
    public function testModeNotSpecified()
    {
        $_SERVER['argv'] = ['app.php'];
        $commandFactory = $this->createMock(CommandFactory::class);
        $app = new Application($commandFactory);

        $this->expectException(ApplicationException::class);
        $this->expectExceptionMessage('Application mode not specified');

        $app->run();
    }
    /**
     * @return void
     * @throws ApplicationException
     * @throws Exception
     * @throws SocketException
     */
    public function testUnknownMode()
    {
        $_SERVER['argv'] = ['app.php', 'mode'];
        $commandFactory = $this->createMock(CommandFactory::class);
        $app = new Application($commandFactory);

        $this->expectException(ApplicationException::class);
        $this->expectExceptionMessage('Unknown mode');

        $app->run();
    }

    /**
     * @return void
     * @throws ApplicationException
     * @throws Exception
     * @throws SocketException
     */
    public function testStartServer()
    {
        $_SERVER['argv'] = ['app.php', 'server'];
        $commandFactory = $this->createMock(CommandFactory::class);
        $app = new Application($commandFactory);
        $command = $this->createMock(ChatServer::class);

        $commandFactory
            ->expects(self::once())
            ->method('getChatServer')
            ->willReturn($command);
        $command->expects(self::once())->method('execute');

        $app->run();
    }
    /**
     * @return void
     * @throws ApplicationException
     * @throws Exception
     * @throws SocketException
     */
    public function testStartClient()
    {
        $_SERVER['argv'] = ['app.php', 'client'];
        $commandFactory = $this->createMock(CommandFactory::class);
        $app = new Application($commandFactory);
        $command = $this->createMock(ChatClient::class);

        $commandFactory
            ->expects(self::once())
            ->method('getChatClient')
            ->willReturn($command);
        $command->expects(self::once())->method('execute');

        $app->run();
    }
}
