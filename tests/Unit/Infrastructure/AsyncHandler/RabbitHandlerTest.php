<?php

namespace Tests\Unit\Infrastructure\AsyncHandler;

use App\Application\AsyncHandler\LeadRequest;
use App\Infrastructure\AsyncHandler\RabbitHandler;
use App\Infrastructure\RabbitClient;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class RabbitHandlerTest extends TestCase
{
    private RabbitClient&MockObject $rabbitClient;
    private RabbitHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rabbitClient = $this->createMock(RabbitClient::class);
        $this->handler = new RabbitHandler($this->rabbitClient);
    }

    public function testSendRequestSendsEncodedMessage(): void
    {
        $leadRequest = new LeadRequest(leadId: 123);

        $expectedMessage = json_encode(['leadId' => 123], JSON_UNESCAPED_UNICODE);

        $this->rabbitClient->expects($this->once())
            ->method('sendMessage')
            ->with($expectedMessage);

        $this->handler->sendRequest($leadRequest);
    }
}
