<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Algorithm;

class CycledListDetector
{
    public function hasCycle(?ListNode $list): bool
    {
        if (null === $list) {
            return false;
        }

        $current = $list;
        $hash = [];

        do {
            $objectId = spl_object_id($current);

            if (isset($hash[$objectId])) {
                return true;
            } else {
                $hash[$objectId] = true;
            }

            $current = $current->getNext();
        } while (null !== $current);

        return false;
    }
}
