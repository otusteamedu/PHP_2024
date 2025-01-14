<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5;

use Apeskovatzkov\Hw5\Contracts\RunnableInterface;

class Client implements RunnableInterface
{

    public function run(): void
    {
        echo 'iam client';
    }
}