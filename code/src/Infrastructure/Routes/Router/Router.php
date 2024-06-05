<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Router;

use App\Application\UseCase\AddNews\Request\AddNewsRequest;
use App\Application\UseCase\ReportNews\Request\ReportNewsRequest;
use App\Infrastructure\Http\ListNewsController;
use App\Infrastructure\Http\ReportNewsController;
use App\Infrastructure\Routes\Http\BurgerController;

class Router
{
    private ?string $order;
    private ?string $type;
    private const STRATEGY_PATH = 'App\Infrastructure\Strategy';

    public function __construct()
    {
        $this->order = $_POST['order']?? null;
        $this->type = $_POST['type']?? null;
    }

    public function runController()
    {
        # order && type
        $this->order = ucfirst(strtolower($this->order));
        $strategyDir = self::STRATEGY_PATH.'\\'.$this->order.'Strategy';
        $strategyClass = $this->order.'Strategy';

        if (!file_exists($strategyDir)) {
            http_response_code(404);
            return 'Тип продукта не найден';
        }

        //&& !class_exists($strategyClass

        $recipe = ucfirst(strtolower($this->type));
        http_response_code(201);
        $controller = $this->order.'Controller';
        return new $controller($recipe);
    }
}