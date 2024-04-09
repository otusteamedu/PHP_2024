# Сложность

Затрудняюсь оценить. Возможно, $$O(n)$$, где n - количество букв. Алгоритм рекурсивный - трудно его оценить.

# Решение

```php
class Solution
{

    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        if (strlen($digits) === 0) {
            return [];
        }

        $map = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $pairs = [];

        for ($i = 0; $i < strlen($digits); $i++) {
            $digit = $digits[$i];
            $pairs = [...$pairs, ...array_map(fn (string $letter) => [$digit, $letter], $map[$digit])];
        }

        return $this->concat('', [], $digits, $pairs);
    }

    private function concat(string $combination, array $result, string $digits, array $pairs): array
    {
        if (!$digits) {
            $result[$combination] = $combination;

            return $result;
        }

        if (array_key_exists($combination, $result)) {
            return $result;
        }

        $currentDigit = substr($digits, 0, 1);
        $nextDigit = substr($digits, 1);

        $offset = 0;
        foreach ($pairs as [$digit, $letter]) {
            $offset++;
            if ($currentDigit !== $digit) {
                continue;
            }

            $result = $this->concat($combination . $letter, $result, $nextDigit, array_slice($pairs, $offset));
        }

        return $result;
    }
}
```
