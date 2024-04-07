<?php

declare(strict_types=1);

namespace Otus\Hw14;

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class LinkedListCycle
{
    const NODE_COUNT_LIMIT = 10000;
    const NODE_VAL_LIMIT_MIN = -100000;
    const NODE_VAL_LIMIT_MAX = 100000;

    /**
     * @param ListNode|null $head
     * @return bool
     */
    public function hasCycle(?ListNode $head): bool
    {
        // Если список пуст или содержит только один элемент, значит цикла нет
        if ($head == null || $head->next == null) return false;

        $count = 0; // Количество узлов в списке
        $visited = []; // Хэш-таблица для отслеживания посещенных узлов

        while ($head != null) {
            ++$count;
            if (!$this->checkNodeValLimits($head->val) || !$this->checkNodeCountLimits($count)) return false;

            if (isset($visited[$head->val])) {
                return true; // Если узел уже был посещен, значит, есть цикл
            }
            $visited[$head->val] = true; // Добавление текущего узла в хэш-таблицу
            $head = $head->next; // Переход к следующему узлу
        }

        return false;
    }

    /**
     * @param int $count
     * @return bool
     */
    private function checkNodeCountLimits(int $count): bool
    {
        return 0 < $count && $count < self::NODE_COUNT_LIMIT;
    }

    /**
     * @param int $val
     * @return bool
     */
    private function checkNodeValLimits(int $val): bool
    {
        return self::NODE_VAL_LIMIT_MIN <= $val && $val <= self::NODE_VAL_LIMIT_MAX;
    }
}
