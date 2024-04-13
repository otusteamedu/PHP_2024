<?php

declare(strict_types=1);

namespace Hukimato\App;

use Exception;
use Hukimato\App\Routers\Router;
use Throwable;

class App
{
    /**
     * @throws Throwable
     */
    public function run()
    {
        try {
            $actionDto = Router::route();
        } catch (Throwable $e) {
            throw new Exception("Invalid route {$_SERVER['REQUEST_METHOD']}  {$_SERVER['REQUEST_URI']}");
        }
        $actionClass = $actionDto->actionClass;
        $action = new $actionClass($actionDto->urlPath, $actionDto->urlPattern);
        $action->run();
    }
}
