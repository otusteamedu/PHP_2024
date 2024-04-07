# Сложность

$$O(n)$$

**Обоснование**
Количество итераций зависит только от количества элементов, не имеет вложенных циклов.

# Решение

```php
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
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle(?ListNode $head): bool
    {
        if ($head?->next === null) {
            return false;
        }

        for ($slow = $head, $fast = $head->next; $fast !== null; $slow = $slow->next, $fast = $fast->next) {
            $next = $fast->next;

            if ($next === null) {
                return false;
            }

            if ($slow === $fast || $slow === $next) {
                return true;
            }

            $fast = $next;
        }

        return false;
    }
}

```
