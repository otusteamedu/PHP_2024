<?php
declare(strict_types=1);

namespace App\Application\UseCase\Cooking\CookingStep;

use App\Application\Interface\Observer\SubscriberInterface;
use App\Domain\Entity\DTO\DTO;

class AddIngrediancesStep implements SubscriberInterface
{

    public function __construct(
        DTO $product,
    ){}

    private function addIngrediances(): void
    {
        echo "Добавление ингредиентов...".PHP_EOL;
        sleep(2);
        $this->repositorySetStatus(3);
    }

    public function update(int $status): void
    {
        // TODO: Implement update() method.
    }
}