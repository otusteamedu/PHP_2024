<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Domain\Entity;

use SlavaMakhov\OtusArchitectureApp\Domain\ValueObject\Priority;
use SlavaMakhov\OtusArchitectureApp\Domain\ValueObject\Name;

class Condition
{
    /** @var int|null */
    private ?int $id = null;

    /**
     * @param Priority $priority
     * @param Name $name
     * @param ConditionList $conditionList
     */
    public function __construct(
        private readonly Priority      $priority,
        private readonly Name          $name,
        private readonly ConditionList $conditionList
    )
    {
    }

    /**
     * Метод получает параметр id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Метод получает параметр name
     *
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * Метод получает параметр priority
     *
     * @return Priority
     */
    public function getPriority(): Priority
    {
        return $this->priority;
    }

    /**
     * Метод получает параметр conditionList
     *
     * @return ConditionList
     */
    public function getConditionList(): ConditionList
    {
        return $this->conditionList;
    }
}
