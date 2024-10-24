<?php

declare(strict_types=1);

namespace Evgenyart\Hw19;

class SolutionIntersectionofTwoLinkedLists
{
    public function getIntersectionNode(ListNode $listA, ListNode $listB): ?ListNode
    {
        if ($listA->next == null || $listB->next == null) {
            return null;
        }

        $originalListA = $listA;
        $originalListB = $listB;
        $longList = $shortList = null;

        $lenA = $lenB = 1;

        do {
            $lenA++;
            $listA = $listA->next;
        } while ($listA->next !== null);

        do {
            $lenB++;
            $listB = $listB->next;
        } while ($listB->next !== null);

        $minLength = min($lenA, $lenB);

        if ($minLength == $lenA) {
            $longList = $originalListB;
            $shortList = $originalListA;
        } else {
            $longList = $originalListA;
            $shortList = $originalListB;
        }

        $difference = abs($lenA - $lenB);

        for ($i = 0; $i < $difference; $i++) {
            $longList = $longList->next;
        }

        while ($longList !== $shortList) {
            $longList = $longList->next;
            $shortList = $shortList->next;
        }

        return $shortList;
    }
}
