<?php

declare(strict_types=1);

namespace Hukimato\App\Routers;

use Hukimato\App\Actions\Users\DeleteAction;
use Hukimato\App\Actions\Users\GetAction;
use Hukimato\App\Actions\Users\PostAction;
use Throwable;

class Router
{
    const ROUTES = [
        'users' => [
            'GET' => GetAction::class,
            'POST' => PostAction::class,
            'DELETE' => DeleteAction::class,
        ],
    ];

    /**
     * @throws Throwable
     */
    public static function route(): string
    {
        return static::ROUTES[static::getUrlPath()][static::getMethodName()];
    }

    protected static function getUrlPath()
    {
        return substr($_SERVER['REQUEST_URI'], 1, strpos($_SERVER['REQUEST_URI'] . '?', '?') - 1);
    }

    protected static function getMethodName()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }
}
