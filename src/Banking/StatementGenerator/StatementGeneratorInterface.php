<?php

declare(strict_types=1);

namespace App\Banking\StatementGenerator;

interface StatementGeneratorInterface
{
    /**
     * @throws \Exception
     */
    public function generate(GenerateStatementData $data): void;
}
