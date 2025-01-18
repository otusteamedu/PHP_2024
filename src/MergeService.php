<?php

namespace Den\Php2024;

use Exception;
use http\Exception\BadUrlException;

class MergeService
{
    public const MAX_COUNT_NODES = 50;
    public const MAX_VALUE = 100;
    public const MIN_VALUE = -100;

    public static function mergeTwoList(NodeList $list1, NodeList $list2): NodeList
    {
        if (!self::checkingSorting($list1) || !self::checkingSorting($list2)) {
            throw new Exception(
                'Списки должны быть отсортирован по возрастанию'
                , 400
            );
        }

        if (
            $list1->minValue() < self::MIN_VALUE
            || $list1->maxValue() > self::MAX_VALUE
            || $list2->minValue() < self::MIN_VALUE
            || $list2->maxValue() > self::MAX_VALUE
        ) {
            throw new Exception(
                'Значения списка должны быть в диапазоне от ' . self::MIN_VALUE . ' до ' . self::MAX_VALUE
                , 400
            );
        }

        if (
            $list1->countNodes() > self::MAX_COUNT_NODES
            || $list2->countNodes() > self::MAX_COUNT_NODES
        ) {
            throw new Exception('Превышено максимально допустимое количество узлов в списке', 400);
        }

        if (is_null($list1->value)) {
            return $list2;
        }

        if (is_null($list2->value)) {
            return $list1;
        }

        $tmpNode = $resultList = new NodeList();
        $isNotFullNull = true;
        while ($isNotFullNull) {
            if (is_null($list1)) {
                $tmpNode->value = $list2->value;
                $list2 = $list2->next;
            } elseif (is_null($list2)) {
                $tmpNode->value = $list1->value;
                $list1 = $list1->next;
            } elseif ($list1->value >= $list2->value) {
                $tmpNode->value = $list2->value;
                $list2 = $list2->next;
            } else {
                $tmpNode->value = $list1->value;
                $list1 = $list1->next;
            }

            $isNotFullNull = !is_null($list1) || !is_null($list2);

            if ($isNotFullNull) {
                $tmpNode->next = new NodeList();
                $tmpNode = $tmpNode->next;
            }
        }

        return $resultList;
    }

    public static function checkingSorting(NodeList $list): bool
    {
        $currentNode = $list;
        $result = true;
        while (!is_null($currentNode->next)) {
            if ($currentNode->value > $currentNode->next->value) {
                $result = false;
                break;
            }

            $currentNode = $currentNode->next;
        }

        return $result;
    }
}
