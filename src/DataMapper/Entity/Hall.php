<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\Entity;

use Alogachev\Homework\DataMapper\ORM\Column;
use Alogachev\Homework\DataMapper\ORM\Id;
use Alogachev\Homework\DataMapper\ORM\IdAttributeDictionary;
use Alogachev\Homework\DataMapper\ORM\Table;

#[Table(name: 'hall')]
class Hall
{
    public function __construct(
        #[Id(strategy: IdAttributeDictionary::AUTO_INCREMENT_STRATEGY)]
        #[Column(name: 'id', type: 'integer', nullable: false)]
        private int $id,
        #[Column(name: 'name', type: 'string', nullable: false)]
        private string $name,
        #[Column(name: 'capacity', type: 'integer', nullable: false)]
        private int $capacity,
        #[Column(name: 'rows_count', type: 'integer', nullable: false)]
        private int $rowsCount
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getRowsCount(): int
    {
        return $this->rowsCount;
    }

    public function setRowsCount(int $rowCount): self
    {
        $this->rowsCount = $rowCount;

        return $this;
    }

    public static function create(string $name, int $capacity, int $rowsCount): self
    {
        return new self(IdAttributeDictionary::SURROGATE_ID, $name, $capacity, $rowsCount);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'capacity' => $this->capacity,
            'rows_count' => $this->rowsCount,
        ];
    }
}
