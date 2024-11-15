<?php

use Naimushina\Chat\Client;
use Naimushina\Chat\ConfigManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Naimushina\Chat\Socket;

class ClientTest extends TestCase
{
    /**
     * @var (Socket&MockObject)|MockObject
     */
    private $sock;
    /**
     * @var ConfigManager
     */
    private ConfigManager $configManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sock = $this->getMockBuilder(Socket::class)
            ->onlyMethods(['connect', 'read', 'write', 'close'])
            ->getMock();

        $this->configManager = new ConfigManager();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testStopOnExit()
    {
        $this->sock->expects(self::once())->method('close');
        $clientApp = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([$this->sock, $this->configManager])
            ->onlyMethods(['getInput'])
            ->getMock();
        $clientApp->method('getInput')->willReturn('exit');
        $clientApp->run();
        $this->expectOutputString(
            'Input message' . PHP_EOL
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testSendMessage()
    {
        $input = 'new message';
        $inputBytes = strlen($input);
        $this->sock->method('read')->willReturn("Received $inputBytes bytes");
        $clientApp = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([$this->sock, $this->configManager])
            ->onlyMethods(['getInput'])
            ->getMock();
        $clientApp->method('getInput')->willReturn($input, 'exit');
        $clientApp->run();

        $this->expectOutputString(
            'Input message' . PHP_EOL .
            "Server confirmed: Received $inputBytes bytes" . PHP_EOL .
            'Input message' . PHP_EOL
        );
    }
}
