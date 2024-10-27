<?php

declare(strict_types=1);

namespace App\Infrastructure\Output;

use App\Domain\Output\AppendedTextInterface;
class NewsTextAppended
{
    public function printDocuments(AppendedTextInterface ...$newsFactory)
    {
        foreach ($newsFactory as $value) {
            echo $value->getText()->getValue() . PHP_EOL . PHP_EOL;
        }
    }
}