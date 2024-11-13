<?php

declare(strict_types=1);

namespace App\Application\Ingredients;

use App\Application\AbstractDecorator;
use App\Domain\Entity\ProductInterface;
use App\Domain\Entity\Ingredients\Ham;

class AddHam extends AbstractDecorator
{
    public function __construct(
        ProductInterface $product
    ) {
        parent::__construct($product);
        $this->addIngredient(new Ham());
    }
}
