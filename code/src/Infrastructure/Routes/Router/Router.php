<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Router;

class Router
{
    private ?string $order;
    private ?string $type;
    private string $controllers_path;

    public function __construct()
    {
        $this->order = $_POST['order']?? null;
        $this->type = $_POST['type']?? null;
        $this->controllers_path = getenv("INFRASTRUCTURE_PATH")."Routes\Http\\";
    }

    public function runController()
    {
        # order = product type && type = recipe
        $this->order = ucfirst(strtolower($this->order));
        $controllerName = $this->order."Controller";
        $controllerClass = $this->controllers_path.$controllerName;

        if (!class_exists($controllerClass)) {
            http_response_code(404);
            return 'Продукт не найден';
        }

        http_response_code(201);
        return (new $controllerClass($this->type))->run();
    }
}