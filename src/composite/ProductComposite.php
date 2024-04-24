<?php

declare(strict_types=1);

namespace Afilipov\Hw16\composite;

class ProductComposite implements IProduct
{
    private array $components = [];

    public function addComponent(IProduct $component): void
    {
        $this->components[] = $component;
    }

    public function prepare(): void
    {
        foreach ($this->components as $component) {
            /* @var IProduct $component */
            $component->prepare();
        }
    }
}
