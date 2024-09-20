<?php

declare(strict_types=1);

namespace App\Domain\Entity;

interface MealInterface
{
    public function getName(): string;
    public function prepare(): void;

}