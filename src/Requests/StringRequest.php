<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Requests;

class StringRequest
{
    private array $server;
    private array $request;

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->request = $_REQUEST;
    }

    public function isPost(): bool
    {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }

    public function isEmptyString(): bool
    {
        return empty($this->getString());
    }

    public function isValidString(): bool
    {
        $stack = [];
        $string = $this->getString();

        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === '(') {
                $stack[] = '(';
            } else if ($string[$i] === ')') {
                if (empty($stack)) {
                    return false;
                }

                array_pop($stack);
            } else {
                return false;
            }
        }

        return empty($stack);
    }

    private function getString(): ?string
    {
        return $this->request['string'] ?? null;
    }
}
