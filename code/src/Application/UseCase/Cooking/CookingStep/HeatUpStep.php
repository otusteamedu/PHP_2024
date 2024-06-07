<?php
declare(strict_types=1);

namespace App\Application\UseCase\Cooking\CookingStep;

use App\Domain\Entity\Product;

class HeatUpStep implements \App\Application\Interface\Observer\SubscriberInterface
{
    public function __construct(
        Product $product
    ){}
    private function heatUp(): void
    {
        echo "Отправляем в печь...".PHP_EOL;
        sleep(7);
        $this->repositorySetStatus(4);
    }

    public function update(int $status): void
    {
        // TODO: Implement update() method.
    }
}