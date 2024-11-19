<?php

namespace Functional;

use App\Domain\Enum\ServiceMessage;
use App\Domain\Service\ClientService;
use App\Domain\Service\ServerService;
use Codeception\Test\Unit;
use Generator;

class ServerStopChatTest extends Unit
{
    /**
     * @dataProvider createTestCases
     */
    public function testServerKeepChat(
        ServerService $serverService,
        ClientService $clientService,
        array $expectedAnswers
    ) {
        $actualAnswers[] = $serverService->initializeChat();
        $actualAnswers[] = $clientService->initializeChat();

        $serverService->beginChat();

        foreach ($clientService->keepChat() as $clientPost) {
            $actualAnswers[] = $clientPost;
            break;
        }

        foreach ($serverService->stopChat() as $post) {
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
                ServiceMessage::ClientStoppedChat->value
                . ServiceMessage::ServerStopped->value
            ]
        ];
    }
}
