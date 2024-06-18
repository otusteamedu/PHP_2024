<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Router;

use App\Application\UseCase\Request\Request;
use App\Infrastructure\Builder\RecipeBuilder;
use App\Infrastructure\Config\Config;
use App\Infrastructure\Observer\Publisher;
use App\Infrastructure\Repository\InitDb;
use App\Infrastructure\Repository\PostgreRepository;
use App\Infrastructure\Routes\Http\Controller;

class Router
{
    private ?string $recipe;
    private ?string $type;
    private ?string $ingredient;
    private ?string $comment;

    public function __construct()
    {
        $this->type = $_POST['type']?? null;
        $this->recipe = $_POST['recipe']?? null;
        $this->ingredient = $_POST['ingredient']?? null;
        $this->comment = $_POST['comment']?? null;
    }

    /**
     * @throws \Exception
     */
    public function runController(): string
    {
        # order = product type && type = recipe
        $strategy = ucfirst(strtolower($this->type));
        $recipe = ucfirst(strtolower($this->recipe));
        $ingredient = $this->ingredient? ucfirst(strtolower($this->ingredient)): null;
        $comment = $this->comment?? null;
        $request = new Request($strategy, $recipe, $ingredient,$comment);

        return (new Controller(
            new PostgreRepository(
                new InitDb()
            ),
            new Publisher(),
            new RecipeBuilder(),
            new Config()
        ))->run($request);
    }
}