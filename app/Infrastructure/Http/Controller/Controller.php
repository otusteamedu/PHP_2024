<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Infrastructure\Main\Request;
use Exception;

abstract class Controller
{
    protected ?Request $request = null;

    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function runAction(?string $action = null, ?array $params = []): mixed
    {
        $method = dashesToCamelCase($action);
        method_exists($this, $method) or throw new \Exception('Method not found');

        return $this->$method(...$params);
    }
}
