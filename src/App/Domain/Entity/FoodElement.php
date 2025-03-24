<?php

namespace App\Domain\Entity;

abstract class FoodElement
{
    protected string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name = 'Noname')
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Состав блюда
     */
    abstract function getComposite(): string;
}