<?php

declare(strict_types=1);

namespace Otus\DbPattern\Models;

class Movie
{
    private array $dirtyFields = [];

    public function __construct(
        private ?int $id,
        private string $title,
        private ?string $startDate,
        private ?string $endDate,
        private ?float $rentalCost
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @return float|null
     */
    public function getRentalCost(): ?float
    {
        return $this->rentalCost;
    }

    /**
     * @param $id
     * @return void
     */
    public function setId($id): void
    {
        $this->setField('id', $id);
    }

    /**
     * @param $title
     * @return void
     */
    public function setTitle($title): void
    {
        $this->setField('title', $title);
    }

    /**
     * @param $startDate
     * @return void
     */
    public function setStartDate($startDate): void
    {
        $this->setField('start_date', $startDate);
    }

    /**
     * @param $endDate
     * @return void
     */
    public function setEndDate($endDate): void
    {
        $this->setField('end_date', $endDate);
    }

    /**
     * @param $rentalCost
     * @return void
     */
    public function setRentalCost($rentalCost): void
    {
        $this->setField('rental_cost', $rentalCost);
    }

    /**
     * @param string $fieldName
     * @param $newValue
     * @return void
     */
    private function setField(string $fieldName, $newValue): void
    {
        if (property_exists($this, $fieldName)) {
            $currentValue = $this->$fieldName;

            if ($currentValue !== $newValue) {
                $this->$fieldName = $newValue;
                $this->dirtyFields[$fieldName] = $newValue;
            }
        }
    }

    /**
     * @return array
     */
    public function getDirtyFields(): array
    {
        return $this->dirtyFields;
    }

    /**
     * @return void
     */
    public function clearDirtyFields(): void
    {
        $this->dirtyFields = [];
    }
}
