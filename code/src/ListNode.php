<?php
namespace AlexAgapitov\OtusComposerProject;
class ListNode {

    public int $val = 0;
    public ?ListNode $next = null;

    function __construct(?int $val = 0, ?ListNode $next = null) {
        $this->val = $val;
        $this->next = $next;
    }

    function setNext(ListNode $next) {
        $this->next = $next;
    }
}