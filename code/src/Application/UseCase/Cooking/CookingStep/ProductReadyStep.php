<?php
declare(strict_types=1);

namespace App\Application\UseCase\Cooking\CookingStep;


use App\Domain\Entity\DTO\DTO;

class ProductReadyStep implements \App\Application\Interface\Observer\SubscriberInterface
{
    public function __construct(
        DTO $product
    ){}
    private function ready(): void
    {
        echo "Запаковываем...".PHP_EOL;
        sleep(2);
        $this->repositorySetStatus(5);
    }

    public function update(int $status): void
    {
        // TODO: Implement update() method.
    }
}