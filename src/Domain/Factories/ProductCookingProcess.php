<?php

declare(strict_types=1);

namespace Domain\Factories;

class ProductCookingProcess extends CookingProcess
{
    public function cook(): void
    {
        echo 'Cooking product.' . PHP_EOL;
    }

    protected function postCook(): void
    {
        parent::postCook();

        echo 'Product cooked.' . PHP_EOL;
    }
}
