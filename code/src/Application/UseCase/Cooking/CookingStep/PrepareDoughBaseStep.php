<?php
declare(strict_types=1);

namespace App\Application\UseCase\Cooking\CookingStep;

use App\Application\Interface\Observer\SubscriberInterface;
use App\Domain\Entity\Product;

class PrepareDoughBaseStep implements SubscriberInterface
{
    public function __construct(
        Product $product,
    ){}

    private function prepare(): void
    {
        echo "Подготовка теста...".PHP_EOL;
        sleep(5);
        $this->repositorySetStatus(2);
    }

    public function update(int $status): void
    {

    }
}