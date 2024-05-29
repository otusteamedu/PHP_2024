<?php
declare(strict_types=1);
namespace App\Infrastructure\Router;

use App\Application\UseCase\AddNews\Request\AddNewsRequest;
use App\Infrastructure\Http\AddNewsController;

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

        switch ($this->path) {
            case 'add':
                # Todo: Вынести в отдельную функцию
                if (array_key_exists('url',$_POST)) {
                    $post = $_POST['url'];
                } else {
                    http_response_code(400);
                    return 'Параметр url не передан';
                }

                # Preparing the request
                $meta = get_meta_tags($post);
                $title = $meta['title']?: 'Title does not found';
                $request = new AddNewsRequest($post, $title);

                $controller = new AddNewsController();
                http_response_code(201);
                return $controller->handle($request);
            case 'list':

            case'report':

            default:
                return http_response_code(400);
        }
    }

    private function getRequestPath(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return rtrim(ltrim(str_replace('index.php', '', $path), '/'), '/');
    }

}