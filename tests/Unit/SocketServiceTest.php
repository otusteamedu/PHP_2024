<?php

namespace Unit;

use App\Domain\Exception\SocketException;
use App\Domain\Service\SocketService;
use Codeception\Test\Unit;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Socket;

class SocketServiceTest extends Unit
{
    use MockeryPHPUnitIntegration;

    private Socket $socket;
    private SocketService $socketService;

    protected function setUp(): void
    {
        $this->socketService = new SocketService();
        $this->socketService->unlink();
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function testUnlinkSocket()
    {
        $this->socketService
            ->create()
            ->bind();

        $this->socketService->unlink();
        $this->assertFileNotExists($this->socketService->getSocketPath());
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function testCreateSocket()
    {
        $socket = $this->socketService->create();

        $this->assertInstanceOf(SocketService::class, $socket);
        $this->socketService->unlink();
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function testBindSocket()
    {
        $this->socketService
            ->create()
            ->bind();

        $this->assertFileExists($this->socketService->getSocketPath());
        $this->socketService->unlink();
    }


    /**
     * @return void
     * @throws SocketException
     */
    public function testListenSocket()
    {
        $socket = $this->socketService
            ->create()
            ->bind()
            ->listen();

        $this->assertInstanceOf(SocketService::class, $socket);
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function testReadGeneratorSocket()
    {
        $this->socketService
            ->create()
            ->bind()
            ->listen();

        $this->socketServiceClient = new SocketService();
        $this->socketServiceClient
            ->create()
            ->connect();

        $this->socket = $this->socketService->accept();
        $this->socketService->write('test-string', $this->socket);

        $expectedString = '';
        foreach ($this->socketServiceClient->getReadGenerator() as $message) {
            $this->socketService->write('test-string', $this->socket);
            $expectedString = $message;
            break;
        }

        $this->assertSame($expectedString, 'test-string');
    }
}
