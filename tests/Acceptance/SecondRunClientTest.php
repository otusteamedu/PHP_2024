<?php

namespace Acceptance;

use App\Controller\Console\Controller;
use App\Domain\Enum\ServiceCommand;
use App\Domain\Enum\ServiceMessage;
use App\Domain\Service\ConfigService;
use Codeception\Test\Unit;
use Generator;
use Support\TestingData\TestingData;

class SecondRunClientTest extends Unit
{
    public function setUp(): void
    {
        $this->writeTestingCommandsIntoFile();
    }

    /**
     * @dataProvider createTestCase
     */
    public function testRunClientTest(
        array $clientStartCommand,
        array $expectedAnswers
    ) {
        $clientController = new Controller();
        $clientController->run($clientStartCommand['clientStart']);

        $actualAnswers[] = $this->getActualAnswers();

        $this->assertSame($expectedAnswers, $actualAnswers);
    }

    public static function createTestCase(): Generator
    {
        yield [
            [ 'clientStart' => [ServiceCommand::ClientStart->value] ],
            [
                trim(
                    ServiceMessage::ClientStarted->value
                    . ServiceMessage::ServerMessage->value
                    . ServiceMessage::WelcomeToChat->value
                    . PHP_EOL

                    . ServiceMessage::ClientInvitation->value
                    . ServiceMessage::ServerMessage->value
                    . ServiceMessage::ServerAnswer->value
                    . '"' . TestingData::TEST_WORD . '"'
                    . ServiceMessage::ReceivedBytes->value
                    . strlen(TestingData::TEST_WORD) . ';'
                    . PHP_EOL

                    . ServiceMessage::ClientInvitation->value
                    . ServiceMessage::ServerMessage->value
                    . ServiceMessage::ServerAnswer->value
                    . '"' . ServiceCommand::EmailValidate->value
                    . ' ' . TestingData::CHECK_EMAIL_QUERY . '"'
                    . ServiceMessage::ReceivedBytes->value
                    . strlen(
                        ServiceCommand::EmailValidate->value . ' '
                        . TestingData::CHECK_EMAIL_QUERY
                    ) . ';'

                    . ServiceMessage::CheckEmailResult->value
                    . TestingData::CHECK_EMAIL_RESULT . PHP_EOL

                    . ServiceMessage::ClientInvitation->value
                    . ServiceMessage::ServerMessage->value
                    . ServiceMessage::ServerAnswer->value
                    . '"' . ServiceCommand::SelectQuery->value
                    . ' ' . TestingData::CHECK_SELECT_QUERY_POSITIVE . '"'
                    . ServiceMessage::ReceivedBytes->value
                    . strlen(
                        ServiceCommand::SelectQuery->value . ' '
                        . TestingData::CHECK_SELECT_QUERY_POSITIVE
                    ) . ';'

                    . ServiceMessage::QuerySelectSuccess->value
                    . TestingData::CHECK_SELECT_QUERY_POSITIVE_RESULT
                    . PHP_EOL

                    . ServiceMessage::ClientInvitation->value
                    . ServiceMessage::ServerMessage->value
                    . ServiceMessage::ServerAnswer->value
                    . '"' . ServiceCommand::SelectQuery->value
                    . ' ' . TestingData::CHECK_SELECT_QUERY_NEGATIVE . '"'
                    . ServiceMessage::ReceivedBytes->value
                    . strlen(
                        ServiceCommand::SelectQuery->value . ' '
                        . TestingData::CHECK_SELECT_QUERY_NEGATIVE
                    ) . ';'

                    . ServiceMessage::QuerySelectError->value
                    . PHP_EOL

                    . ServiceMessage::ClientInvitation->value
                    . ServiceMessage::ClientStopped->value
                )
            ],
        ];
    }

    private function writeTestingCommandsIntoFile(): void
    {
        $testingCommands = TestingData::TEST_WORD
                        . PHP_EOL

                        . ServiceCommand::EmailValidate->value . ' '
                        . TestingData::CHECK_EMAIL_QUERY
                        . PHP_EOL

                        . ServiceCommand::SelectQuery->value . ' '
                        . TestingData::CHECK_SELECT_QUERY_POSITIVE
                        . PHP_EOL

                        . ServiceCommand::SelectQuery->value . ' '
                        . TestingData::CHECK_SELECT_QUERY_NEGATIVE
                        . PHP_EOL

                        . ServiceCommand::ChatStop->value;

        $config = ConfigService::class;
        file_put_contents($config::get('INPUT_STREAM'), $testingCommands);
    }

    /**
     * @return false|string
     */
    private function getActualAnswers(): false|string
    {
        $config = ConfigService::class;

        return trim(file_get_contents($config::get('OUTPUT_CLIENT_STREAM')));
    }
}
