<?php

declare(strict_types=1);

namespace Application;

use Domain\Builders\ProductBuilder;
use Domain\Decorators\Ingredients\BunDecorator;
use Domain\Decorators\Ingredients\CatchupDecorator;
use Domain\Decorators\Ingredients\MustardDecorator;
use Domain\Decorators\Ingredients\OnionDecorator;
use Domain\Decorators\Ingredients\LettuceDecorator;
use Domain\Decorators\Ingredients\PattyDecorator;
use Domain\Decorators\Ingredients\SausageDecorator;
use Domain\Decorators\Ingredients\TomatoDecorator;
use Domain\Factories\ProductCookingProcess;
use Domain\Strategies\ProductStrategyInterface;
use Infrastructure\Container;

class App
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public static function run(): void
    {
        $app = new static();

        $app->buildProduct('Burger',
            [
                BunDecorator::class,
                PattyDecorator::class,
                LettuceDecorator::class,
                OnionDecorator::class,
                TomatoDecorator::class,
                CatchupDecorator::class,
                BunDecorator::class,
            ]
        );

        $app->buildProduct('Sandwich',
            [
                BunDecorator::class,
                LettuceDecorator::class,
                TomatoDecorator::class,
            ]
        );

        $app->buildProduct('HotDog',
            [
                BunDecorator::class,
                SausageDecorator::class,
                MustardDecorator::class,
            ]
        );
    }

    public function buildProduct(string $productName, array $productIngredients): void
    {
        $strategy = $this->container->get($productName);
        $notifier = $this->container->get('StatusNotifier');
        $cookingHandlerChain = $this->container->get('CookingHandlerChain');

        $builder = static::getProductBuilder($strategy);

        foreach ($productIngredients as $ingredient) {
            $builder->addIngredient($ingredient);
        }

        $product = $builder->build();

        echo $product->getDescription() . PHP_EOL;

        $cookingHandlerChain->handle('preparing');

        $cookingProcess = new ProductCookingProcess();

        $cookingProcess->execute();

        echo PHP_EOL;
    }

    protected static function getProductBuilder(ProductStrategyInterface $strategy): ProductBuilder
    {
        return new ProductBuilder($strategy);
    }
}
