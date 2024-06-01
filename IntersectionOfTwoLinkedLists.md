# Approach

1. Определить, пересекаются ли списки в принципе: если их конечные элементы совпадают - идём на следующий шаг алгоритма, если нет - возвращаем null.

2. Если списки пересекаются, то приводим их длину к одному - минимальному из двух - значению, "обрезая" самый длинный список с начала.

3. Начинаем параллельный обход списков. Так как теперь их длины совпадают, то и первый общий элемент будет иметь один и тот же индекс. Находим его и возвращаем.

# Complexity

- Time complexity:
  $$O(m + n)$$

где m, n - длины списков.

**Обоснование:**

Количество итераций линейно зависит от количества элементов в списках

- Space complexity:
  $$O(1)$$

**Обоснование:**

Алгоритм не использует дополнительных структур для хранения промежуточных данных.

# Code

```
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        for (
            $node1 = $headA, $node2 = $headB, $length1 = 1, $length2 = 1;
            $node1->next !== null || $node2->next !== null;
            $node1 = $node1->next ?? $node1, $node2 = $node2->next ?? $node2
        ) {
            if ($node1 === $node2) {
                return $node1;
            }

            $length1 = $length1 + ($node1->next !== null);
            $length2 = $length2 + ($node2->next !== null);
        }

        if ($node1 !== $node2) {
            return null;
        }

        $minLength = min($length1, $length2);

        $node1 = $headA;
        $node2 = $headB;
        $length1Diff = $length1 - $minLength;
        $length2Diff = $length2 - $minLength;

        while ($length1Diff > 0) {
            $node1 = $node1->next;
            $length1Diff--;
        }

        while ($length2Diff > 0) {
            $node2 = $node2->next;
            $length2Diff--;
        }

        while ($node1 !== $node2) {
            $node1 = $node1->next;
            $node2 = $node2->next;
        }

        return $node1;
    }
}

```
