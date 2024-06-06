<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Http;

use App\Application\Interface\RecipeInterface;
use App\Application\Interface\StrategyInterface;
use App\Application\UseCase\CookingUseCase;
use App\Infrastructure\Repository\PostgreRepository;


class Controller
{
    private string $strategyPath;
    private StrategyInterface $strategy;
    private string $strategyName;
    private RecipeInterface $recipe;
    private string $recipeName;
    private string $recipePath;
    private PostgreRepository $repository;
    public function __construct(string $strategy, string $recipeFromRequest){
        $this->repository = new PostgreRepository();

        $this->strategyPath = getenv("INFRASTRUCTURE_PATH")."Strategy\\".$strategy."Strategy\\";
        $this->strategyName = $strategy."Strategy";
        $this->recipeName = $recipeFromRequest.'Recipe';
        $this->recipePath = $this->strategyPath."\\".$strategy."Recipe\\";
    }

    public function run(): void
    {
        $this->getStrategy();
        new CookingUseCase($this->strategy, $this->repository);
    }


    private function getStrategy(): void
    {
        $this->getRecipe();
        $this->strategy = new ($this->strategyPath.$this->strategyName)($this->recipe);
    }

    private function getRecipe(): void
    {

        $recipeClass = $this->recipePath.$this->recipeName;

        if (!class_exists($recipeClass)) {
            http_response_code(401);
            return;
        }
        $this->recipe = new $recipeClass();
    }

}