<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Http;

use AllowDynamicProperties;
use App\Application\Interface\RecipeInterface;
use App\Application\UseCase\CookingUseCase;
use App\Infrastructure\Repository\PostgreRepository;
use App\Infrastructure\Strategy\BurgerStrategy\BurgerStrategy;


class BurgerController
{
    private ?BurgerStrategy $strategy = null;
    private RecipeInterface $recipe;
    private string $recipeName;
    private string $recipePath;
    private PostgreRepository $repository;
    public function __construct(string $recipeFromRequest){
        $this->recipeName = $recipeFromRequest;
        $this->repository = new PostgreRepository();
        $this->recipePath = getenv("INFRASTRUCTURE_PATH")."Strategy\\";
    }

    public function run(): void
    {
        $this->getStrategy();
        new CookingUseCase($this->strategy, $this->repository);
    }


    private function getStrategy(): void
    {
        if (!$this->getRecipe()) {
            http_response_code(401);
            return;
        }
        $this->strategy = new BurgerStrategy($this->recipe);
    }

    private function getRecipe(): bool
    {
        $recipe = ucfirst(strtolower($this->recipeName));
        $recipe .= 'Recipe';
        $recipePath = self::RECIPE_PATH.'\\'.$this->recipeName.'\\Recipe';
        $recipe = file_exists($recipePath);
        if ($recipe) {
            require_once $recipePath;
            $recipeClass = $this->recipeName.'Recipe';
            $this->recipe = new $recipeClass();
            return true;
        }
        http_response_code(401);
        return false;
    }

}