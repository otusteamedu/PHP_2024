<?php

declare(strict_types=1);

namespace App\Routing;

use App\Controller\Api\BracketController;
use App\Controller\HomepageController;
use RedisException;

class Routing
{
    /**
     * @param string $uri
     * @return string
     * @throws RedisException
     */
    public function getRout(string $uri): string
    {
        return match (parse_url($uri, PHP_URL_PATH)) {
            '/api' => (new BracketController())->getValidation(),
            default => (new HomepageController())->homepage(),
        };
    }
}
