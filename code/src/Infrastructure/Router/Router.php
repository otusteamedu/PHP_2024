<?php
declare(strict_types=1);
namespace App\Infrastructure\Router;

use App\Application\UseCase\AddNews\Request\AddNewsRequest;
use App\Infrastructure\Http\AddNewsController;
use App\Infrastructure\Http\ListNewsController;
use App\Infrastructure\Http\ReportNewsController;

class Router
{
    private string $path;
    private array $routes = [];

    public function __construct()
    {
        $this->routes = [
            'add',
            'list',
            'report'
        ];
        $this->path = $this->getRequestPath();
    }

    public function runController(): array|int|string
    {

        if (!in_array($this->path, $this->routes)) {
            http_response_code(404);
            return 'URL не найден';
        }

        return match ($this->path) {
            'add' => $this->addRoute(),
            'list' => $this->listRoute(),
            'report' => $this->reportRoute(),
            default => http_response_code(400),
        };
    }

    private function getRequestPath(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return rtrim(ltrim(str_replace('index.php', '', $path), '/'), '/');
    }

    /**
     * @return int|string
     */
    private function addRoute(): string|int
    {
        if (array_key_exists('url', $_POST)) {
            $post = $_POST['url'];
        } else {
            http_response_code(400);
            return 'Параметр url не передан';
        }

        # Preparing the request
        $meta = get_meta_tags($post);
        $title = $meta['title']?? $meta['description']?? 'Title does not found';
        $request = new AddNewsRequest($post, $title);

        $controller = new AddNewsController();
        http_response_code(201);
        return $controller->handle($request);
    }

    private function listRoute(): array|string
    {
        $controller = new ListNewsController();
        http_response_code(201);
        return $controller->handle();
    }

    private function reportRoute(): array|string
    {
//        if (array_key_exists('url', $_POST)) {
//            $post = $_POST['url'];
//        } else {
//            http_response_code(400);
//            return 'Параметр url не передан';
//        }

        return $_POST;

//        $controller = new ReportNewsController();
//        http_response_code(201);
//        return $controller->handle();
    }

}