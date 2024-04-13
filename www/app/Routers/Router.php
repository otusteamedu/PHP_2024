<?php

declare(strict_types=1);

namespace Hukimato\App\Routers;

use Hukimato\App\Actions\Posts\DeleteAction as PostDeleteAction;
use Hukimato\App\Actions\Posts\GetAction as PostGetAction;
use Hukimato\App\Actions\Posts\ListAction as PostListAction;
use Hukimato\App\Actions\Posts\PostAction as PostPostAction;
use Hukimato\App\Actions\Posts\PutAction as PostPutAction;
use Hukimato\App\Actions\Users\DeleteAction as UserDeleteAction;
use Hukimato\App\Actions\Users\GetAction as UserGetAction;
use Hukimato\App\Actions\Users\PostAction as UserPostAction;
use Hukimato\App\Actions\Users\PutAction as UserPutAction;
use Throwable;

class Router
{
    const USERNAME_PATTERN = '[^/]+';
    const POST_ID_PATTERN = '\d+';

    const ROUTES = [
        '#users$#' => [
            'POST' => UserPostAction::class,
        ],
        '#users\/(?<username>' . self::USERNAME_PATTERN . ')$#' => [
            'GET' => UserGetAction::class,
            'PUT' => UserPutAction::class,
            'DELETE' => UserDeleteAction::class,
        ],
        '#users\/(?<username>' . self::USERNAME_PATTERN . ')\/posts$#' => [
            'POST' => PostPostAction::class,
            'GET' => PostListAction::class,
        ],
        '#users\/(?<username>' . self::USERNAME_PATTERN . ')\/posts\/(?<post_id>' . self::POST_ID_PATTERN . ')$#' => [
            'GET' => PostGetAction::class,
            'PUT' => PostPutAction::class,
            'DELETE' => PostDeleteAction::class,
        ],
    ];

    /**
     * @throws Throwable
     */
    public static function route(): ActionDTO
    {
        foreach (static::ROUTES as $url => $methods) {
            if (preg_match($url, static::getUrlPath())) {
                return new ActionDTO(
                    static::ROUTES[$url][static::getMethodName()],
                    $url,
                    static::getUrlPath()
                );
            }
        }

        return false;
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
