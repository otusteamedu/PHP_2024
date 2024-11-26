<?php

namespace App\Domain\Factory;

use App\Domain\Entity\NameAge;

class NameAgeFactory
{
    public function create(string $name, int $age): NameAge
    {
        return (new NameAge())
            ->setName($name)
            ->setAge($age);
    }
}
