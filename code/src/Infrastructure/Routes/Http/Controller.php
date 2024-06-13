<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Http;

use App\Application\Interface\Observer\PublisherInterface;
use App\Application\Interface\RecipeInterface;
use App\Application\Interface\StrategyInterface;
use App\Application\UseCase\CreateProductRecord\CreateProductRecordUseCase;
use App\Application\UseCase\Cooking\CookingUseCase;
use App\Application\UseCase\Cooking\StatusChangeHandler;
use App\Application\UseCase\Request\Request;
use App\Infrastructure\Config\Config;
use App\Infrastructure\Observer\Publisher;
use App\Infrastructure\Repository\PostgreRepository;


class Controller
{
    private PostgreRepository $repository;
    private StrategyInterface $strategy;
    private RecipeInterface $recipe;
    private PublisherInterface $publisher;
    private Config $config;
    private const COOKING_STEPS = 'Cooking_steps';
    private string $strategyName;
    private string $strategyPath;
    private string $recipeName;
    private string $recipePath;
    private ?string $ingredients = null;

    public function __construct(){
        $this->repository = new PostgreRepository();
        $this->publisher = new Publisher();
        $this->config = new Config();
    }

    public function run(Request $request): string
    {
        $this->prepareParams($request);

        if (!$this->getStrategy()) {
            http_response_code(404);
            return "Такого продукта не существует";
        }
        $productRecord = new CreateProductRecordUseCase(
            $this->strategy,
            $this->repository
        );


        try {
            $product = $productRecord();
            $statusHandler = new StatusChangeHandler($product);
            $cookingSteps = $this->config->getSection(self::COOKING_STEPS);

            # Подписываем шаги приготовления
            foreach ($cookingSteps as $step => $value) {
                $stepClass = getenv("SOURCE_USECASE_COOKING_STEPS_PATH").$step;
                $this->publisher->subscribe(new $stepClass($statusHandler));
            }
            $cooking = new CookingUseCase($this->publisher);
            $statusHandler->publisher->subscribe($cooking);

             # Запускаем приготовление
            $cooking($product);

        } catch (\Exception $e) {
            http_response_code(401);
            return $e->getMessage();
        }

        return "Заказ приготовлен. Ждем Вас снова!";
    }


    /**
     * @return bool
     */
    private function getStrategy(): bool
    {
        if (!$this->getRecipe()) {
            return false;
        }
        $this->strategy = new ($this->strategyPath.$this->strategyName)($this->recipe);
        return true;
    }

    private function getRecipe(): bool
    {
        $recipeClass = $this->recipePath.$this->recipeName;
        if (!class_exists($recipeClass)) {
            return false;
        }
        $this->recipe = new $recipeClass($this->ingredients);
        return true;
    }

    /**
     * @param Request $request
     * @return void
     */
    private function prepareParams(Request $request): void
    {
        $this->strategyPath = getenv("INFRASTRUCTURE_PATH") . "Strategy\\" . $request->type . "Strategy\\";
        $this->strategyName = $request->type . "Strategy";
        $this->recipeName = $request->recipe . 'Recipe';
        $this->recipePath = $this->strategyPath . $request->type . "Recipe\\";
        $this->ingredients = $request->ingredient;
    }
}