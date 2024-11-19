<?php

namespace Acceptance;

use App\Controller\Console\Controller;
use App\Domain\Enum\ServiceCommand;
use App\Domain\Enum\ServiceMessage;
use App\Domain\Service\ConfigService;
use Codeception\Test\Unit;
use Generator;
use Support\TestingData\TestingData;

class FirstRunServerTest extends Unit
{
    public function setUp(): void
    {
        $config = ConfigService::class;

        file_put_contents($config::get('INPUT_STREAM'), '');
    }

    /**
     * @dataProvider createTestCase
     */
    public function testRunServerTest(
        array $serverStartCommand,
        array $expectedAnswers
    ) {
        $serverController = new Controller();
        $serverController->run($serverStartCommand['serverStart']);

        $actualAnswers[] = $this->getActualAnswers();

        $this->assertSame($expectedAnswers, $actualAnswers);
    }

    public static function createTestCase(): Generator
    {
        yield [
            ['serverStart' => ['default'] ],
            [ trim(ServiceMessage::Default->value) ],
        ];

        yield [
            [ 'serverStart' => [ServiceCommand::ServerStart->value] ],
            [
                trim(
                    ServiceMessage::ClientMessage->value
                    . TestingData::TEST_WORD
                    . PHP_EOL

                    . ServiceMessage::ClientMessage->value
                    . ServiceCommand::EmailValidate->value . ' '
                    . TestingData::CHECK_EMAIL_QUERY
                    . PHP_EOL

                    . ServiceMessage::ClientMessage->value
                    . ServiceCommand::SelectQuery->value . ' '
                    . TestingData::CHECK_SELECT_QUERY_POSITIVE
                    . PHP_EOL

                    . ServiceMessage::ClientMessage->value
                    . ServiceCommand::SelectQuery->value . ' '
                    . TestingData::CHECK_SELECT_QUERY_NEGATIVE
                    . PHP_EOL

                    . ServiceMessage::ClientStoppedChat->value
                    . ServiceMessage::ServerStopped->value,
                )
            ],
        ];
    }

    /**
     * @return false|string
     */
    private function getActualAnswers(): false|string
    {
        $config = ConfigService::class;

        return trim(file_get_contents($config::get('OUTPUT_SERVER_STREAM')));
    }
}
