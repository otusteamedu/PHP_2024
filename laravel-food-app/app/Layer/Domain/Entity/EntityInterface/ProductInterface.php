<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\EntityInterface;

interface ProductInterface
{
    public function createProduct();
    public function getName();
}
