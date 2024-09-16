<?php

namespace Komarov\Hw8\App;

use Komarov\Hw8\Exception\AppException;

class App
{
    /**
     * @throws AppException
     */
    public function run(): void
    {
        if (!is_array($_POST['list1']) || !is_array($_POST['list2'])) {
            http_response_code(400);

            throw new AppException("Bad request");
        }

        $list1 = $this->createList($_POST['list1']);
        $list2 = $this->createList($_POST['list2']);

        var_dump(Solution::mergeTwoLists($list1, $list2));
    }

    private function createList(array $list): ListNode
    {
        $dummy = new ListNode();
        $current = $dummy;

        foreach ($list as $item) {
            $current->next = new ListNode($item);
            $current = $current->next;
        }

        return $dummy->next;
    }
}
