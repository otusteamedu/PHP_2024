<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\List;

final class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function getIntersectionNode($headA, $headB)
    {
        $short = $headA;
        $long = $headB;
        $aLen = 0;
        $bLen = 0;
        while ($short->next) {
            $aLen++;
            $short = $short->next;
        }
        while ($long->next) {
            $bLen++;
            $long = $long->next;
        }

        $long = $headB;
        $short = $headA;
        if ($aLen > $bLen) {
            $long = $headA;
            $short = $headB;
        }
        $offset = abs($aLen - $bLen);
        unset($aLen, $bLen);
        for ($i = 0; $i < $offset; $i++) {
            $long = $long->next;
        }
        unset($offset);
        while (!empty($short)) {
            if ($short === $long) {
                return $short;
            }
            $short = $short->next;
            $long = $long->next;
        }

        return null;
    }
}
