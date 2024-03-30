<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\Event;

use function array_map;

final readonly class Event
{
    private array $criteria;

    public function __construct(
        private int $id,
        private int $priority,
        Criteria $criteria,
        Criteria ...$criterias
    ) {
        $criterias[] = $criteria;
        $this->criteria = $criterias;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getCriteria(): array
    {
        return $this->criteria;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'priority' => $this->priority,
            'criteria' => array_map(static fn (Criteria $criteria): array => $criteria->toArray(), $this->criteria)
        ];
    }
}
