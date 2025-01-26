<?php

namespace Den\Php2024;

use Exception;

class SolutionHasCycle
{
    private const LIMIT_COUNT_NODES = 10000;
    private const MIN_VALUE_NODE = -100000;
    private const MAX_VALUE_NODE = 100000;

    public static function hasCycle(ListNode $listNode)
    {
        $hash = [];
        while (true) {
            $hash[] = $listNode;

            if (count($hash) > self::LIMIT_COUNT_NODES) {
                throw new Exception('Превышен лимит количества узлов в list');
            }

            if ($listNode->value > self::MAX_VALUE_NODE || $listNode->value < self::MIN_VALUE_NODE) {
                $max = self::MAX_VALUE_NODE;
                $min = self::MIN_VALUE_NODE;
                $value = $listNode->value;
                throw new Exception("Значение узла $value не входит в диапазон от $min до $max", 400);
            }

            $listNode = $listNode->next;

            if (in_array($listNode, $hash)) {
                return true;
            } elseif (empty($listNode)) {
                return false;
            }
        }
    }
}
