# Сложность

$$O(4^n)$$, где n - количество цифр.

**Обоснование**
В качестве основания берем максимально возможное количество букв для одной цифры. Сложность экспоненциальная, так как имеем столько вложенных циклов, сколько цифр подаётся на вход алгоритму.

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

        return $this->concat($digits, '');
    }

    private function concat(string $digits, string $combination): array
    {
        if (strlen($digits) === 0) {
            return [$combination];
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

        $result = [];

        foreach ($map[substr($digits, 0, 1)] as $letter) {
            $result[] = $this->concat(substr($digits, 1), "$combination$letter");
        }

        return array_merge(...$result);
    }
}
```
