<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\Query;

readonly class QueryItem
{
    public function __construct(
        private string $name,
        /**
         * @var int - Один из типов для PDO.
         */
        private int $type,
        private mixed $value,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
