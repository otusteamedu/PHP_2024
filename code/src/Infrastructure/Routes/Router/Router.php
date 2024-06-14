<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Router;

use App\Application\UseCase\Request\Request;
use App\Infrastructure\Routes\Http\Controller;

class Router
{
    private ?string $recipe;
    private ?string $type;
    private ?string $ingredient;

    public function __construct()
    {
        $this->type = $_POST['type']?? null;
        $this->recipe = $_POST['recipe']?? null;
        $this->ingredient = $_POST['ingredient']?? null;
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
        $request = new Request($strategy, $recipe, $ingredient);

        return (new Controller())->run($request);
    }
}