<?php

declare(strict_types=1);

namespace Rmulyukov\Hw4;

final class BracesChecker
{
    private array $braces = [];

    public function check(string $braces): bool
    {
        if (empty($braces)) {
            return false;
        }

        for ($i = 0; $i < strlen($braces); $i++) {
            if (!$this->handle($braces[$i])) {
                return false;
            }
        }
        return !$this->hasBraces();
    }

    private function handle(string $brace): bool
    {
        if ($brace === ')') {
            return $this->removeBrace();
        }
        $this->addBrace();
        return true;
    }

    private function removeBrace(): bool
    {
        if (!$this->hasBraces()) {
            return false;
        }
        array_pop($this->braces);
        return true;
    }

    private function addBrace(): void
    {
        $this->braces[] = ')';
    }

    private function hasBraces(): bool
    {
        return count($this->braces) > 0;
    }
}
