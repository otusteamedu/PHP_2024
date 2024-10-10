<?php
namespace AlexAgapitov\OtusComposerProject;
class ListNode {

    public int $val = 0;
    public ?ListNode $next = null;

    function __construct(?int $val = 0) {
        $this->val = $val;
    }

    function setNext(ListNode $next) {
        $this->next = $next;
    }
}