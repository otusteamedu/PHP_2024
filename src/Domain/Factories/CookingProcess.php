<?php

declare(strict_types=1);

namespace Domain\Factories;

abstract class CookingProcess
{
    abstract public function cook(): void;

    public function execute(): void
    {
        $this->preCook();
        $this->cook();
        $this->postCook();
    }

    protected function preCook(): void
    {
        echo 'Pre-cooking steps.' . PHP_EOL;
    }

    protected function postCook(): void
    {
        echo 'Post-cooking steps.' . PHP_EOL;
    }
}
