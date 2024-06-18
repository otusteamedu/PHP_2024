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
use App\Domain\Repository\RepositoryInterface;
use App\Infrastructure\Adapter\PizzaAdapter\PizzaInterface;
use App\Infrastructure\Builder\RecipeBuilder;
use App\Infrastructure\Config\Config;
use App\Infrastructure\Observer\Publisher;
use App\Infrastructure\Repository\PostgreRepository;
use Exception;


class Controller
{
    private PostgreRepository $repository;
    private StrategyInterface $strategy;
    private RecipeInterface|PizzaInterface|null $recipe;
    private RecipeBuilder $builder;
    private PublisherInterface $publisher;
    private Config $config;
    private const COOKING_STEPS = 'Cooking_steps';
    private string $strategyPath;

    public function __construct(
        RepositoryInterface $repository,
        PublisherInterface $publisher,
        RecipeBuilder $builder,
        Config $config
    ){
        $this->repository = $repository;
        $this->publisher = $publisher;
        $this->builder = $builder;
        $this->config = $config;
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

        $this->builder->setType($this->strategy->getType());
        $this->builder->setBaseRecept($this->strategy->getRecipe());
        $this->builder->setAdditional($request->ingredient);
        $this->builder->setComment($request->comment);
        $product = $this->builder->build();


        # Создаем запись в БД о продукте
        $productRecord = new CreateProductRecordUseCase(
            $product,
            $this->repository
        );

        try {
            $product = $productRecord();
            $statusHandler = new StatusChangeHandler($product, $this->repository, new Publisher());
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

        $return = "Ваш " . $request->recipe;
        if (!is_null($this->builder->getAdditional())) $return .= " с " . $this->builder->getAdditional();
        $return .= " готов. ";
        if (!is_null($this->builder->getComment())) $return .= "Ваше пожелание '" . $this->builder->getComment() ."' выполнено.";
        $return .= "  Ждем Вас снова!";

        return $return;
    }


    /**
     * @param Request $request
     * @return bool
     */
    private function getStrategy(Request $request): bool
    {
        $this->strategyPath = getenv("INFRASTRUCTURE_PATH") . "Strategy\\" . $request->type . "Strategy\\";
        $this->recipe = $this->getRecipe($request);
        $strategyName = $request->type . "Strategy";
        if (!class_exists($this->strategyPath. $strategyName)) {
            return false;
        }
        $this->strategy = new ($this->strategyPath. $strategyName)($this->recipe);
        return true;
    }

    /**
     * @param Request $request
     * @return RecipeInterface|null
     */
    private function getRecipe(Request $request): RecipeInterface|null
    {
        $recipeName = $request->recipe . 'Recipe';
        $recipePath = $this->strategyPath.$request->type."Recipe\\";
        $ingredients = $request->ingredient;
        $recipeClass = $recipePath . $recipeName;
        if (!class_exists($recipeClass)) {
            return null;
        }
        return new $recipeClass($ingredients);
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