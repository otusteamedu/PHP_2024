<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Phone;

final class Button
{
    private string $letters;
    public ?Button $next = null;

    public function __construct(string $letters)
    {
        $this->letters = $letters;
    }

    public function getCombinations(string $parent = ''): string
    {
        $result = [];
        for ($i = 0; $i < strlen($this->letters); $i++) {
            $letter = $parent . $this->letters[$i];
            if ($this->next) {
                $result[] = $this->next->getCombinations($letter);
                continue;
            }
            $result[] = $letter;
        }

        return implode(',', $result);
    }
}
