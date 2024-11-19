<?php

declare(strict_types=1);

namespace App\Domain\Constant;

enum BankStatementStatus: string
{
// @phpstan-ignore-next-line
    case NEW = 'new';
    case IN_PROCESS = 'in_process';
    case DONE = 'done';
}
