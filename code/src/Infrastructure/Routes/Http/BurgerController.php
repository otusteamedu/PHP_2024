<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Http;

use App\Application\Interface\RecipeInterface;
use App\Application\UseCase\CookingUseCase;
use App\Infrastructure\Repository\PostgreRepository;
use App\Infrastructure\Strategy\BurgerStrategy\BurgerStrategy;


class BurgerController
{

    private const RECIPE_PATH = 'App\Infrastructure\Strategy\BurgerStrategy';

    private ?BurgerStrategy $strategy = null;

    private RecipeInterface $recipe;
    private string $recipeName;
    private PostgreRepository $repository;
    public function __construct(string $recipeFromRequest){
        $this->recipeName = $recipeFromRequest;
        $this->repository = new PostgreRepository();
    }

    public function __invoke(): void
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
        $recipePath = self::RECIPE_PATH.'\\'.$this->recipeName.'\\Recipe.php';
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