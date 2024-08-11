<?php

declare(strict_types=1);

namespace App\Application\Actions\Product;

use App\Domain\Product\{AbstractCookingProcess, AbstractProductCook, HasCompositionInterface};

class BuildProductAction
{
    public function execute(AbstractProductCook $cook, AbstractCookingProcess $cookingProcess, ?string ...$productCustomizers): HasCompositionInterface
    {
        return $cookingProcess->cook($cook, ...$productCustomizers);
    }
}
