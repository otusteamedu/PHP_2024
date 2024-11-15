<?php


use Naimushina\Chat\App;
use Naimushina\Chat\Client;
use Naimushina\Chat\ConfigManager;
use Naimushina\Chat\Server;
use Naimushina\Chat\Socket;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
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
        $fakeSockConnection = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $this->sock = $this->getMockBuilder(Socket::class)
            ->onlyMethods(['accept', 'receive', 'write', 'close'])
            ->getMock();
        $this->sock->method('accept')->willReturn($fakeSockConnection);
        $this->configManager = new ConfigManager();
    }

    /**
     * Проверяем что сервер закрывает соединение при получении сообщения с текстом exit
     * @return void
     * @throws Exception
     */
    public function testStopOnExit()
    {
        $this->sock->method('receive')->willReturn(['exit', 65536]);
        $this->sock->expects(self::once())->method('close');
        $serverApp = new Server($this->sock, $this->configManager);
        $serverApp->run();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testReceiveMessage(){

        $this->sock->method('receive')->willReturn(['new message', 12],['exit', 65536]);
        $this->sock->expects(self::once())->method('write');
        $serverApp = new Server($this->sock, $this->configManager);
        $serverApp->run();
        $this->expectOutputString(
            'ready to receive' . PHP_EOL .
            'Received message: new message' . PHP_EOL .
            'Received message: exit' . PHP_EOL
        );
    }

}