<?php

namespace Irayu\Hw8;

/**
 * Без создания Dummy узлов, хоть с ними и красиво, но хотелось попробовать без $dummy = new ListNode();
 */

class Solution
{
    public const STRATEGY_CUT_OFF = 'cutOff';
    public const STRATEGY_RECURSION = 'recursion';

    public function __construct(protected ?string $strategy = null)
    {
    }

    /**
     * @param ?ListNode $list1
     * @param ?ListNode $list2
     * @return ?ListNode
     */
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        match ($this->strategy) {
            self::STRATEGY_CUT_OFF => $result = $this->cutOffNode($list1, $list2),
            self::STRATEGY_RECURSION => $result = $this->mergeRecursively($list1, $list2),
            default => $result = $this->fastestMerge($list1, $list2),
        };

        return $result;
    }

    /**
     * Сложность по времени: O(n), где n - количество элементов в обоих списках.
     * Сложность по памяти: O(1), так как оперируем константным количеством переменных.
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode|null
     */
    protected function cutOffNode(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $result = null;
        $pointer = null;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val > $list2->val) {
                $node = $list2;
                $list2 = $list2->next;
            } else {
                $node = $list1;
                $list1 = $list1->next;
            }

            if ($result === null) {
                $result = $pointer = $node;
            } else {
                $pointer->next = $node;
                $pointer = $pointer->next;
            }
        }

        $node = $list1 === null ? $list2 : $list1;
        if ($result === null) {
            $result = $node;
        } else {
            $pointer->next = $node;
        }

        return $result;
    }

    /**
     * Сложность по времени: O(n), где n - количество элементов в обоих списках.
     * Сложность по памяти: O(n), так как для каждой итерации выделяется кусочек памяти.
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode|null
     */
    protected function mergeRecursively(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        if ($list1 === null) {
            return $list2;
        }

        if ($list2 === null) {
            return $list1;
        }

        if ($list1->val < $list2->val) {
            $list1->next = $this->mergeTwoLists($list1->next, $list2);

            return $list1;
        }

        $list2->next = $this->mergeTwoLists($list1, $list2->next);

        return $list2;
    }

    /**
     * Некрасивый аналог первого, но по тестам превосходит постоянно.
     * Сложность по времени: O(n), где n - количество элементов в обоих списках.
     * Сложность по памяти: O(1), так как оперируем константным количеством переменных.
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode|null
     */
    protected function fastestMerge(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        if ($list2 === null) {
            return $list1;
        }

        if ($list1 === null) {
            return $list2;
        }

        $result = $list1;

        if ($list1->val > $list2->val) {
            $result = $list2;
            $list2 = $list1;
            $list1 = $result;
        }

        while ($list1->next !== null && $list2 !== null) {
            if ($list1->next->val <= $list2->val) {
                $list1 = $list1->next;
            } else {
                $listStore = $list1->next;
                $list1->next = $list2;
                $list2 = $list2->next;
                $list1->next->next = $listStore;
            }
        }

        if ($list1->next === null) {
            $list1->next = $list2;
        }

        return $result;
    }
}
