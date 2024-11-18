<?php

namespace App\Domain\Model\Product\ProductUpdate;

use App\Domain\Model\AbstractModel;

class ProductUpdateModel extends AbstractModel
{
    public function __construct(
        public string $id,
        public ?string $title,
        public ?string $sku,
        public ?string $category,
        public ?int $price,
        public ?float $volume,
    ) {
    }
}
