<?php

declare(strict_types=1);

namespace App\Banking\StatementGenerator;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

final readonly class NullStatementGenerator implements StatementGeneratorInterface
{
    public function generate(GenerateStatementData $data): void
    {
        $stream = __DIR__ . '/../../../var/log/statements.log';

        (new Logger('name'))
            ->pushHandler(new StreamHandler($stream))
            ->info('The statement was generated', $data->toArray())
        ;
    }
}
