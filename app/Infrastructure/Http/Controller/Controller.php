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
    ) {
    }

    /**
     * @throws Exception
     */
    public function runAction(?string $action = null, ?array $params = []): mixed
    {
        $method = dashesToCamelCase($action);

        if (strlen($method) && method_exists($this, $method)) {
            return $this->$method(...$params);
        }

        if (method_exists($this, self::DEFAULT_ACTION)) {
            return $this->execute(...$params);
        }

        throw new \Exception('Method not found');
    }

    protected function execute(...$args)
    {
    }
}
