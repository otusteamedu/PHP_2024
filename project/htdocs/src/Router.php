<?php
namespace Src;
use Src\Controller;
class Router
{
    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/enqueue') {
            (new Controller())->enqueue();
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('#^/status/([0-9]+)$#', $uri, $matches)) {
            (new Controller())->status((int)$matches[1]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);
        }
    }
}
