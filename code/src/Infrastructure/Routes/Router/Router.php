<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Router;

use App\Application\UseCase\Request\Request;
use App\Infrastructure\Routes\Http\Controller;

class Router
{
    private ?string $order;
    private ?string $type;

    public function __construct()
    {
        $this->order = $_POST['order']?? null;
        $this->type = $_POST['type']?? null;
    }

    public function runController(): string
    {
        # order = product type && type = recipe
        $strategy = ucfirst(strtolower($this->order));
        $recipe = ucfirst(strtolower($this->type));
        $request = new Request($strategy, $recipe);

        return (new Controller())->run($request);
    }
}