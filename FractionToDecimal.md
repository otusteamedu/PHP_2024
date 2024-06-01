# Complexity

- Time complexity:
  $$O(n)$$

где n - количество символов в результирующей строке.

**Обоснование:**

Каждая позиция в результирующей строке обрабатывается один раз.

- Space complexity:
  $$O(n)$$

где n - количество символов в результирующей строке.

**Обоснование:**

Для хранения результата используется массив с количеством элементов, примерно равных количеству символов в результирующей строке.

# Code

```
class Solution
{

    /**
     * @param int $numerator
     * @param int $denominator
     * @return String
     */
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator === 0) {
            return '0';
        }

        $result = ($numerator < 0 xor $denominator < 0) ? '-' : '';
        $result .= abs(intdiv($numerator, $denominator));

        $remainder = $numerator % $denominator;

        if ($remainder === 0) {
            return $result;
        }

        $result .= '.';

        $result .=  implode($this->processRemainder(abs($remainder) * 10, abs($denominator), []));

        return $result;
    }

    private function processRemainder(int $processed, int $denominator, array $result): array
    {
        $partialQuotient = intdiv($processed, $denominator);
        $remainder = $processed % $denominator;

        if ($remainder === 0) {
            $result[] = $partialQuotient;

            return $result;
        }

        $key = "$partialQuotient.$remainder";

        if (array_key_exists($key, $result)) {
            $result[$key] = "($result[$key]";
            $result[] = ')';

            return $result;
        }

        $result[$key] = $partialQuotient;

        return $this->processRemainder($remainder * 10, $denominator, $result);
    }
}

```
