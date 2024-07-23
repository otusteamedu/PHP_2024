<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Infrastructure\Main\Request;
use Exception;

abstract class Controller
{
    protected const DEFAULT_ACTION = 'execute';
    public function __construct(
        protected ?Request $request = null
    )
    {
    }

    /**
     * @throws Exception
     */
    public function runAction(?string $action = null, ?array $params = []): mixed
    {
        $method = dashesToCamelCase($action ?? self::DEFAULT_ACTION);
        method_exists($this, $method) or throw new \Exception('Method not found');

        return $this->$method(...$params);
    }
}
