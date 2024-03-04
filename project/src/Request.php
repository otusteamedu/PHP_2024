<?php

declare(strict_types=1);

namespace SFadeev\HW4;

class Request
{
    /**
     * @param array<string, string> $params
     */
    private function __construct(
        private array $params
    ) {
    }

    /**
     * @return Request
     */
    public static function createFromGlobals(): Request
    {
        return new Request($_POST);
    }

    /**
     * @param string $name
     * @param string|null $default
     * @return string|null
     */
    public function get(string $name, string $default = null): ?string
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }

        return $default;
    }
}
