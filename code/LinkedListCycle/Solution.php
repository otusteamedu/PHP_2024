<?php
namespace LinkedListCycle;

class Solution {
    /**
     * Проверяем связный ли лист обходя его всего один раз
     * Проверяя каждый шаг и следующий за ним одновременно
     * Сложность решения - О(n)
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle(ListNode $head): bool
    {
        $oneStep = $head;
        $twoSteps = $head;

        while ($oneStep && $oneStep->next){
            $oneStep = $oneStep->next;
            $twoSteps = $twoSteps->next->next;

            if($oneStep === $twoSteps){
                return true;
            }
        }
        return false;
    }
}
