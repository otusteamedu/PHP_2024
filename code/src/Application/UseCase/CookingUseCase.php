<?php
declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Interface\StrategyInterface;
use App\Domain\Entity\Product;
use App\Domain\Repository\RepositoryInterface;

class CookingUseCase
{

    private Product $product;
    public function __construct(
        private readonly StrategyInterface $strategy,
        private readonly RepositoryInterface $repository
    ){

        $this->product = new Product(
            $this->strategy->getType(),
            $this->strategy->getRecipe()
        );

    }

    public function __invoke(): void
    {
        # Save product
        $this->repository->save($this->product);

        # Cooking steps
        $this->prepareDoughBase();
        $this->addIngrediances();
        $this->heatUp();
        $this->ready();
    }

    private function prepareDoughBase(): void
    {
        echo "Подготовка теста...";
        sleep(15);
        $this->repositorySetStatus(2);
    }

    private function addIngrediances(): void
    {
        echo "Добавление ингредиентов...";
        sleep(10);
        $this->repositorySetStatus(3);
    }

    private function heatUp(): void
    {
        echo "Отправляем в печь...";
        sleep(20);
        $this->repositorySetStatus(4);
    }

    private function ready(): void
    {
        echo "Запаковываем...";
        sleep(5);
        $this->repositorySetStatus(5);
    }

    /**
     * @param int $status
     * @return void
     */
    private function repositorySetStatus(int $status): void
    {
        $this->repository->setStatus($status, $this->product->getId());
    }

}