<?php

declare(strict_types=1);

namespace Alogachev\Homework\Domain\ValueObject;

use Alogachev\Homework\Domain\Enum\BankStatementStatusEnum;
use InvalidArgumentException;

class BankStatementStatus
{
    private string $value;

    public function __construct(string $value)
    {
        if (is_null(BankStatementStatusEnum::tryFrom($value))) {
            throw new InvalidArgumentException('Неизвестный статус');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
