<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Algorithm;

class Solution
{
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        if (null === $list1 || null === $list2) {
            return null === $list1 ? $list2 : $list1;
        }

        $head = $currentNode = new ListNode(0);

        while (null !== $list1 && null !== $list2) {
            if ($list1->getValue() <= $list2->getValue()) {
                $currentNode->setNext($list1);
                $list1 = $list1->getNext();
            } else {
                $currentNode->setNext($list2);
                $list2 = $list2->getNext();
            }

            $currentNode = $currentNode->getNext();
        }

        if (null !== $list1) {
            $currentNode->setNext($list1);
        }

        if (null !== $list2) {
            $currentNode->setNext($list2);
        }

        return $head->getNext();
    }
}
