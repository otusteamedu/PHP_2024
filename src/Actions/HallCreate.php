<?php

declare(strict_types=1);

namespace Alogachev\Homework\Actions;

use Alogachev\Homework\DataMapper\Entity\Hall;

class HallCreate
{
    public function createHall(): Hall
    {
        return new Hall(0, '', 0, 0);
    }
}
