<?php

declare(strict_types=1);

namespace Hukimato\App;

use Hukimato\App\Actions\ActionInterface;
use Hukimato\App\Routers\Router;
use Throwable;

class App
{
    /**
     * @throws Throwable
     */
    public function run()
    {
        /**
         * @var $actionClass ActionInterface
         */
        $actionClass = Router::route();
        var_dump($actionClass);die;
        (new $actionClass)->run();
    }
}
