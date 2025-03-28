class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        if (!$headA || !$headB) {
            return null;
        }

        $a = $headA;
        $b = $headB;

        while ($a !== $b) {
            $a = $a ? $a->next : $headB; // If end of listA, switch to headB
            $b = $b ? $b->next : $headA; // If end of listB, switch to headA
        }

        return $a;
    }
}