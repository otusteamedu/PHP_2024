<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Http;

use App\Application\Interface\Observer\PublisherInterface;
use App\Application\Interface\RecipeInterface;
use App\Application\Interface\StrategyInterface;
use App\Application\UseCase\Cooking\CookingStep\AddIngrediancesStep;
use App\Application\UseCase\Cooking\CookingStep\HeatUpStep;
use App\Application\UseCase\Cooking\CookingStep\PrepareDoughBaseStep;
use App\Application\UseCase\Cooking\CookingStep\ProductReadyStep;
use App\Application\UseCase\Cooking\CookingUseCase;
use App\Application\UseCase\WorkWithWorkpiece\WorkWithWorkpieceUseCase;
use App\Application\UseCase\Request\Request;
use App\Infrastructure\Observer\Publisher;
use App\Infrastructure\Repository\PostgreRepository;


class Controller
{
    private PostgreRepository $repository;
    private StrategyInterface $strategy;
    private RecipeInterface $recipe;
    private PublisherInterface $publisher;
    private string $strategyName;
    private string $strategyPath;
    private string $recipeName;
    private string $recipePath;

    public function __construct(){
        $this->repository = new PostgreRepository();
        $this->publisher = new Publisher();
    }

    public function run(Request $request): string
    {
        $this->prepareParams($request);

        if (!$this->getStrategy()) {
            http_response_code(404);
            return "Такого продукта не существует";
        }
        $workWithWorkpieceUseCase = new WorkWithWorkpieceUseCase(
            $this->strategy,
            $this->repository
        );

        try {
            $workpiece = $workWithWorkpieceUseCase();
            $this->publisher->subscribe(new PrepareDoughBaseStep($workpiece->recipe));
            $this->publisher->subscribe(new AddIngrediancesStep($workpiece->recipe));
            $this->publisher->subscribe(new HeatUpStep($workpiece->recipe));
            $this->publisher->subscribe(new ProductReadyStep($workpiece->recipe));
            $cooking = new CookingUseCase($this->publisher);
            $cooking($workpiece);
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
        $this->recipe = new $recipeClass();
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
    }
}