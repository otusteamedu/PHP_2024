<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Ids
{
    private array $ids;

    public function __construct(array $ids)
    {
        $this->assertIdsIsValid($ids);
        $this->ids = $ids;
    }

    public function getIds(): array
    {
        return $this->ids;
    }

    private function assertIdsIsValid(array $ids): void
    {
        foreach ($ids as $id) {
            if (is_int($id) === false) {
                throw new \InvalidArgumentException('Все переданные id должны быть числом');
            }
        }
    }
}