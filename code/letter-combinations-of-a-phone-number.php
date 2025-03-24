<?php

class Solution
{
    public array $result = [];

    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        if (strlen($digits) == 0) {
            return [];
        }

        $layouts = [
            2 => range('a', 'c'),
            3 => range('d', 'f'),
            4 => range('g', 'i'),
            5 => range('j', 'l'),
            6 => range('m', 'o'),
            7 => range('p', 's'),
            8 => range('t', 'v'),
            9 => range('w', 'z'),
        ];

        return $this->recursive(0, $digits, $layouts);
    }

    public function recursive($index, $chars, $layouts, $combine = ''): array
    {
        foreach ($layouts[$chars[$index]] as $currentLayout) {
            if ($layouts[$chars[$index + 1]]) {
                $this->recursive($index + 1, $chars, $layouts, $combine . $currentLayout);
            } else {
                $this->result[] = $combine . $currentLayout;
            }
        }

        return $this->result;
    }
}

/**
 * 1. Временная сложность: `O(k^n)`, где `k` (фактически 3 или 4 — фиксированное значение).
 * Из чего следует, что сложность между O(n^3) и O(n!).
 * 2. Пространственная сложность: `O(k^n)` вследствие хранилища результата.
 */
