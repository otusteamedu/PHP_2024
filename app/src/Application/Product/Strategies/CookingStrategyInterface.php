<?php

namespace AnatolyShilyaev\App\Application\Product\Strategies;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Application\Product\Processes\AbstractCookingProcess;

interface CookingStrategyInterface
{
    public function getCookingProcess(Product $product): AbstractCookingProcess;
}
