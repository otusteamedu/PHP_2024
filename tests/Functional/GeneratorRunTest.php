<?php

namespace Functional;

use App\Application\Generator\Console\ClientGenerator;
use App\Application\Generator\Console\ServerGenerator;
use App\Domain\Enum\ServiceMessage;
use App\Domain\Exception\SocketException;
use Codeception\Test\Unit;
use Generator;

class GeneratorRunTest extends Unit
{
    /**
     * @dataProvider createTestCase
     * @throws SocketException
     */
    public function testGeneratorRun(
        array $expectedAnswers
    ) {
        $actualAnswers = [];
        foreach ((new ServerGenerator())->run() as $messageServer) {
            $actualAnswers[] = $messageServer;
            foreach ((new ClientGenerator(STDIN, STDOUT))->run() as $messageClient) {
                $actualAnswers[] = $messageClient;
                break;
            }
            break;
        }
        $this->assertSame($expectedAnswers, $actualAnswers);
    }

    public static function createTestCase(): Generator
    {
        yield [
            [
                ServiceMessage::ServerStarted->value,
                ServiceMessage::ClientStarted->value
            ]
        ];
    }
}
