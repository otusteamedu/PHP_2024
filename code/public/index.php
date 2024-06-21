<?php
declare(strict_types=1);

// Definition for a singly-linked list.
  class ListNode {
      public ?int $val = 0;
      public $next = null;
      function __construct(int $val, $next) {
          $this->val = $val;
          $this->next = $next;
      }
 }


class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode|null
     * listA = [4,1,8,4,5], listB = [5,6,1,8,4,5]
     */
    function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {

        if ($headA === null || $headB === null) {
            return null;
        }

        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = $pointerA === null ? $headB : $pointerA->next;
            $pointerB = $pointerB === null ? $headA : $pointerB->next;
        }

        return $pointerA;

//        $a = $headA;
//        $b = $headB;
//        $count = 0;
//        while ($count !== 2) {
//            if ($a === $b && !is_null($a->next) && !is_null($b->next)) {
//                return $a;
//            }
//            if ($a->next === null) {
//                $a = $headB;
//                $count++;
//            } else {
//                $a = $a->next;
//            }
//
//            if ($b->next === null) {
//                $b = $headA;
//            } else {
//                $b = $b->next;
//            }
//        }
//        return null;
    }

}

$listA = new ListNode(4,
            new ListNode(1,
                new ListNode(8,
                    new ListNode(4,
                        new ListNode(5, null))))
        );

$listB = new ListNode(5,
            new ListNode(6,
                new ListNode(1,
                    new ListNode(8,
                        new ListNode(4,
                            new ListNode(5, null)))))
);

$solution = new Solution();
$result = $solution->getIntersectionNode($listA,$listB);
echo $result->val?? "null";