<?php

declare(strict_types=1);

use Evgenyart\Hw14\ListNode;
use Evgenyart\Hw14\SolutionLinkedListCycle;

require_once(__DIR__ . '/vendor/autoload.php');

#head = [3,2,0,-4], pos = 1
$head4 = new ListNode(-4);
$head3 = new ListNode(0, $head4);
$head2 = new ListNode(2, $head3);
$LinkedList = new ListNode(3, $head2);
$head4->next = $head2;

$SolutionLinkedListCycle = new SolutionLinkedListCycle();
$result = $SolutionLinkedListCycle->hasCycle($LinkedList);

var_dump($result);
