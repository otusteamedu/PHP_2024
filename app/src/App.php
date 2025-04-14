<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App;

use AnatolyShilyaev\App\Application\Product\Processes\BurgerCookingProcess;
use AnatolyShilyaev\App\Application\Product\Strategies\DefaultCookingStrategy;
use AnatolyShilyaev\App\Domain\Product\Services\ProductStatusService;
use AnatolyShilyaev\App\Domain\Product\Services\Chain\BurgerHandler;
use AnatolyShilyaev\App\Domain\Product\Services\Chain\HotDogHandler;
use AnatolyShilyaev\App\Domain\Product\Services\Chain\SandwichHandler;
use AnatolyShilyaev\App\Application\UseCase\GenerateBaseProductUseCase;
use AnatolyShilyaev\App\Infrastructure\Factory\IngredientDecoratorFactory;
use AnatolyShilyaev\App\Application\UseCase\AddIngredientsUseCase;
use AnatolyShilyaev\App\Application\UseCase\CookProductUseCase;
use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Enums\ProductStatus;
use AnatolyShilyaev\App\Domain\Product\Services\ProductStatusNotifier;
use AnatolyShilyaev\App\Infrastructure\Http\GenerateBaseProductController;
use AnatolyShilyaev\App\Infrastructure\Observers\LoggerObserver;

class App
{
    private Router $router;
    private DefaultCookingStrategy $strategy;

    private BurgerHandler $burger;
    private SandwichHandler $sandwich;
    private HotDogHandler $hotdog;

    private Product $baseProduct;

    private GenerateBaseProductUseCase $generateBaseProductUseCase;
    private CookProductUseCase $cookProductUseCase;

    private GenerateBaseProductController $generateBaseProductController;

    public function __construct()
    {
        $this->router = new Router();

        // Стратегия
        $this->strategy = new DefaultCookingStrategy();


        $this->burger = new BurgerHandler();
        $this->sandwich = new SandwichHandler();
        $this->hotdog = new HotDogHandler();

        // Цепочка обязанностей
        $this->burger->setNext($this->sandwich)->setNext($this->hotdog);

        $this->generateBaseProductUseCase = new GenerateBaseProductUseCase($this->burger);
        $this->cookProductUseCase = new CookProductUseCase($this->strategy);

        $this->generateBaseProductController = new GenerateBaseProductController($this->generateBaseProductUseCase);
    }

    public function __invoke(): void
    {

        $this->router->add('/', function () {
            print_r("Hello");
            return "Hello";
        });

        $this->router->add('/base', function () {
            $this->baseProduct = ($this->generateBaseProductController)('sandwich');

            $json = json_encode($this->baseProduct->toArray(), JSON_PRETTY_PRINT);
            echo $json;
            return $json;
        });

        // Декоратор
        $this->router->add('/add', function () {
            $this->baseProduct = ($this->generateBaseProductController)('sandwich');

            $decoratorFactory = new IngredientDecoratorFactory();
            $addIngredientsUseCase = new AddIngredientsUseCase($decoratorFactory);

            $upgradedProduct = $addIngredientsUseCase->execute($this->baseProduct, ['lettuce', 'onion', 'meat']);

            $json = json_encode($upgradedProduct->toArray(), JSON_PRETTY_PRINT);
            echo $json;
            return $json;
        });

        // Наблюдатель
        $this->router->add('/notify', function () {
            $this->baseProduct = ($this->generateBaseProductController)('sandwich');
            $notifier = new ProductStatusNotifier();
            $logger = new LoggerObserver();

            $notifier->attach($logger);

            // Смена статуса
            $statusService = new ProductStatusService($notifier);
            $statusService->changeStatus($this->baseProduct, ProductStatus::COOKING);

            $json = json_encode($this->baseProduct->toArray(), JSON_PRETTY_PRINT);
            echo $json;
            return $json;
        });

        // Шаблонный метод
        $this->router->add('/cook', function () {
            $this->baseProduct = ($this->generateBaseProductController)('burger');

            ($this->cookProductUseCase)($this->baseProduct);
        });

        $this->router->dispatch($_SERVER['REQUEST_URI']);
    }
}
