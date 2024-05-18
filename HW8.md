# HW8

## Задача
https://leetcode.com/problems/merge-two-sorted-lists/

## Решение

```php
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2) {
        $head = new ListNode();
        $current = $head;
        while ($list1 && $list2) {
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }
            $current = $current->next;
        }
        if ($list1) {
            $current->next = $list1;
        }
        if ($list2) {
            $current->next = $list2;
        }
        return $head->next;
    }
}
```

## Обоснование сложноти

Цикл продолжается, пока не достигнут конец хотя бы одного из списков.

Переход к следующему элементу в одном из списков занимает O(1) времени.

Так как мы проходим через каждый элемент обоих списков только один раз,
общее количество итераций цикла while будет равно сумме длин обоих списков,
что составляет O(m + n), где m и n - длины list1 и list2 соответственно.
