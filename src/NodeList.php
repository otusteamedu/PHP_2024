<?php

namespace Den\Php2024;

class NodeList
{
    public function __construct(
        public ?int       $value = null,
        public ?NodeList $next = null,
    )
    {
    }

    public function countNodes(): int
    {
        $count = 0;
        $currentNode = $this;
        while (!is_null($currentNode)) {
            $count++;
            $currentNode = $currentNode->next;
        }

        return $count;
    }

    public function maxValue(): ?int
    {
        $currentNode = $this;
        $result = $currentNode->value;
        $currentNode = $currentNode->next;
        while (!is_null($currentNode)) {
            if ($currentNode->value > $result) {
                $result = $currentNode->value;
            }

            $currentNode = $currentNode->next;
        }

        return !empty($result) ? $result : 0;
    }

    public function minValue(): int
    {
        $currentNode = $this;
        $result = $currentNode->value;
        $currentNode = $currentNode->next;
        while (!is_null($currentNode)) {
            if ($currentNode->value < $result) {
                $result = $currentNode->value;
            }

            $currentNode = $currentNode->next;
        }

        return !empty($result) ? $result : 0;
    }

    public function __toString(): string
    {
        $node = $this;
        $arr[] = $node->value;
        while (!is_null($node->next)) {
            $node = $node->next;
            $arr[] = $node->value;
        }

        return '[' . implode(', ', $arr) . ']';
    }
}
