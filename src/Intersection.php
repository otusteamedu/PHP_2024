<?php

declare(strict_types=1);

class Solution
{

    //Time complexity = O(N)
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        $a1 = $headA;
        $b1 = $headB;
        $a1C = 0;
        $b1C = 0;

        while($a1 || $b1){
            if($a1){$a1C++; $a1 = $a1->next;}
            if($b1){$b1C++; $b1 = $b1->next;}
        }

        $a1 = $headA;
        $b1 = $headB;

        if($a1C > $b1C){
            while($a1C > $b1C){
                $a1 = $a1->next;
                $a1C--;
            }
        } else if ($b1C > $a1C){
            while($b1C > $a1C){
                $b1 = $b1->next;
                $b1C--;
            }
        }
        while($a1 || $b1){
            if($a1 === $b1) return $a1??$b1;
            $a1 = $a1->next;
            $b1 = $b1->next;
        }

        return null;
    }
}


