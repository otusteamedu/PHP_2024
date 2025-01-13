<?php

declare(strict_types=1);

namespace App;

class LinkedList
{
    public ?ListNode $head = null;

    public function append($value): void
    {
        if ($this->head === null) {
            $this->head = new ListNode($value);
        } else {
            $current = $this->head;
            while ($current->next !== null) {
                $current = $current->next;
            }
            $current->next = new ListNode($value);
        }
    }
}
