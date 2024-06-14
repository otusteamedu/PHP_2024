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
use Exception;
use RuntimeException;


class Controller
{
    private PostgreRepository $repository;
    private StrategyInterface $strategy;
    private RecipeInterface $recipe;
    private PublisherInterface $publisher;
    private Config $config;
    private const COOKING_STEPS = 'Cooking_steps';
    private string $strategyPath;

    public function __construct(){
        $this->repository = new PostgreRepository();
        $this->publisher = new Publisher();
        $this->config = new Config();
    }

    public function run(Request $request): string
    {
        if (!$this->getStrategy($request)) {

            $adapter = $this->getAdapter($request);
            if ($adapter) {
                $this->strategy = $adapter;
            } else {
                http_response_code(404);
                return  'Такого продукта не существует';
            }
        }
        # Создаем запись в БД о продукте
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

            # Подписываем Cooking на изменение статуса приготовления
            $statusHandler->publisher->subscribe($cooking);

             # Запускаем приготовление
            $cooking($product);

        } catch (Exception $e) {
            http_response_code(401);
            return $e->getMessage();
        }

        return "Ваш " . $request->recipe . " готов. Ждем Вас снова!";
    }


    /**
     * @param Request $request
     * @return bool
     */
    private function getStrategy(Request $request): bool
    {
        $this->strategyPath = getenv("INFRASTRUCTURE_PATH") . "Strategy\\" . $request->type . "Strategy\\";
        if (!$this->getRecipe($request)) {
            return false;
        }
        $strategyName = $request->type . "Strategy";
        $this->strategy = new ($this->strategyPath. $strategyName)($this->recipe);
        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function getRecipe(Request $request): bool
    {
        $recipeName = $request->recipe . 'Recipe';
        $recipePath = $this->strategyPath.$request->type."Recipe\\";
        $ingredients = $request->ingredient;
        $recipeClass = $recipePath . $recipeName;
        if (!class_exists($recipeClass)) {
            return false;
        }
        $this->recipe = new $recipeClass($ingredients);
        return true;
    }

    /**
     * @param Request $request
     * @return StrategyInterface|false
     */

    private function getAdapter(Request $request): StrategyInterface|false
    {
        $adapterPath = getenv("INFRASTRUCTURE_PATH") . "Adapter\PizzaAdapter\\";
        $strategyClass = $adapterPath."PizzaAdapter";
        if (!class_exists($strategyClass)) {
            return false;
        }
        $recipeClass = $adapterPath.$request->recipe."Recipe";
        if (!class_exists($recipeClass)) {
            return false;
        }
        $this->recipe = new $recipeClass();
        return new $strategyClass($this->recipe);
    }
}