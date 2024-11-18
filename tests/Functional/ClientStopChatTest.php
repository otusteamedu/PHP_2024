<?php

namespace Functional;

use App\Domain\Enum\ServiceMessage;
use App\Domain\Service\ClientService;
use App\Domain\Service\ServerService;
use Codeception\Test\Unit;
use Generator;

class ClientStopChatTest extends Unit
{
    /**
     * @dataProvider createTestCases
     */
    public function testClientKeepStopChat(
        ServerService $serverService,
        ClientService $clientService,
        array         $expectedAnswers
    )
    {
        $actualAnswers[] = $serverService->initializeChat();
        $actualAnswers[] = $clientService->initializeChat();

        $serverService->beginChat();

        foreach ($clientService->keepChat() as $post) {
            $actualAnswers[] = $post;
            break;
        }

        foreach ($clientService->stopChat() as $post) {
            $actualAnswers[] = $post;
            break;
        }

        $this->assertSame($expectedAnswers, $actualAnswers);
    }

    public static function createTestCases(): Generator
    {
        yield [
            new ServerService(),
            new ClientService(STDIN, STDOUT),
            [
                ServiceMessage::ServerStarted->value,
                ServiceMessage::ClientStarted->value,
                ServiceMessage::ServerMessage->value
                . ServiceMessage::WelcomeToChat->value
                . PHP_EOL,
                ServiceMessage::ClientStopped->value
            ]
        ];
    }
}

