<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Web\Router;

use Exception;

class RouteNotFoundException extends Exception
{
    protected $message = '404 Not Found';
}
