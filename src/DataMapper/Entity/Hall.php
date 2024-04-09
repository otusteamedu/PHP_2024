<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\Entity;

use Alogachev\Homework\DataMapper\ORM\Column;
use Alogachev\Homework\DataMapper\ORM\Table;

#[Table(name: 'hall')]
class Hall
{
    public function __construct(
        #[Column(name: 'id', type: 'int', nullable: false)]
        private int $id,
        #[Column(name: 'name', type: 'string', nullable: false)]
        private string $name,
        #[Column(name: 'capacity', type: 'integer', nullable: false)]
        private int $capacity,
        #[Column(name: 'row_count', type: 'integer', nullable: false)]
        private int $rowCount
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

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function setRowCount(int $rowCount): self
    {
        $this->rowCount = $rowCount;

        return $this;
    }
}
