<?php

declare(strict_types=1);

namespace App\Dictionaries;

enum QueueDictionary: string
{
    case BankStatementQueue = 'bank_statement_queue';

    public static function map(): array
    {
        $map = [];
        foreach (self::cases() as $status) {
            $map[$status->value] = $status->value;
        }
        return $map;
    }
}
