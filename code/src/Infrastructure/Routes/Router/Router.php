<?php
declare(strict_types=1);
namespace App\Infrastructure\Routes\Router;

use App\Application\UseCase\AddNews\Request\AddNewsRequest;
use App\Application\UseCase\ReportNews\Request\ReportNewsRequest;
use App\Infrastructure\Http\ListNewsController;
use App\Infrastructure\Http\ReportNewsController;
use App\Infrastructure\Routes\Http\AddNewsController;

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
            $url = $_POST['url'];
        } else {
            http_response_code(400);
            return 'Параметр url не передан';
        }

        # Preparing the request
        $page_content = file_get_contents ($url);
        preg_match_all("#.*<title>(.+)<\/title>.*#isU", $page_content, $titles);
        $title = $titles[1][0];

        $request = new AddNewsRequest($url, $title);

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
        if (array_key_exists('report', $_POST)) {
            $post = $_POST['report'];
        } else {
            http_response_code(400);
            return 'Параметр report не передан';
        }

        $post = explode(',', $post);

        $request = new ReportNewsRequest($post);
        $controller = new ReportNewsController();
        http_response_code(201);
        return $controller->handle($request);
    }

}