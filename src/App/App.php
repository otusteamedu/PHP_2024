<?php

namespace VSukhov\Hw8\App;

use VSukhov\Hw8\Exception\AppException;

class App
{
    /**
     * Сложность
     * Временная сложность: O(n + m)
     * Пространственная сложность: O(1)
     *
     * @return void
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

        var_dump(ListsMerger::merge($list1, $list2));
    }

    private function createList(array $list): NodeList
    {
        $dummy = new NodeList();
        $current = $dummy;

        foreach ($list as $item) {
            $current->next = new NodeList($item);
            $current = $current->next;
        }

        return $dummy->next;
    }
}