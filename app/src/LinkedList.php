<?php

namespace Otus\Hw14;

class LinkedList
{
    /** @var int|null */
    private ?int $pos;

    /** @var array|null */
    private ?array $nodes;

    public function __construct()
    {
        $this->setParams();
    }

    /**
     * @return void
     */
    private function setParams(): void
    {
        $this->nodes = $this->getNodes();
        $this->pos = $_SERVER['argv'][2] ?? null;
    }

    /**
     * @return array|null
     */
    private function getNodes(): ?array
    {
        $nodes = explode(',', $_SERVER['argv'][1]) ?? null;

        if (empty($nodes)) return null;

        return array_map('intval', $nodes);;
    }

    /**
     * @return ListNode|null
     */
    public function getList(): ?ListNode
    {
        if (empty($this->nodes) || $this->pos < 0 || $this->pos >= count($this->nodes)) {
            return null;
        }

        $head = new ListNode($this->nodes[0]);
        $current = $head;

        for ($i = 1; $i < count($this->nodes); $i++) {
            $current->next = new ListNode($this->nodes[$i]);
            $current = $current->next;
        }

        // Находим узел, который будет указывать на начало цикла
        $cycleNode = $head;
        for ($i = 0; $i < $this->pos; $i++) {
            $cycleNode = $cycleNode->next;
        }

        // Направляем последний узел на узел, который создает цикл
        $current->next = $cycleNode;

        return $head;
    }
}
