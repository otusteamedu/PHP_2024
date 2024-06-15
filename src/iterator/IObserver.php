<?php

declare(strict_types=1);

namespace Afilipov\Hw16\iterator;

interface IObserver
{
    public function update(ProductStatus $status): void;
}
