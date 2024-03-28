<?php

declare(strict_types=1);

namespace Hukimato\RedisApp;

use Hukimato\RedisApp\Actions\ActionInterface;
use Hukimato\RedisApp\Routers\Router;
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
        (new $actionClass)->run();
    }
}
