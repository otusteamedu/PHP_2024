<?php
declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Interface\StrategyInterface;
use App\Domain\Entity\Product;

class CookingUseCase
{

    private Product $product;
    public function __construct(
        private readonly StrategyInterface $strategy
    ){
        $this->product = new Product(
            $this->strategy->getType(),
            $this->strategy->getRecipe()
        );
    }

    public function __invoke(): void
    {
        $this->prepareDoughBase();
        $this->addIngrediances();
        $this->heatUp();
        $this->ready();
    }

    private function prepareDoughBase(): void
    {
        echo "Подготовка теста...";
        sleep(15);
        $this->product->setStatus(2);
    }

    private function addIngrediances(): void
    {
        echo "Добавление ингредиентов...";
        sleep(10);
        $this->product->setStatus(3);
    }

    private function heatUp(): void
    {
        echo "Отправляем в печь...";
        sleep(20);
        $this->product->setStatus(4);
    }

    private function ready(): void
    {
        echo "Запаковываем...";
        sleep(5);
        $this->product->setStatus(5);
    }

}