<?php

namespace Irayu\Hw8;

class App
{
    public function run(): void
    {
        $data = [
            [
                'list1' => [1,2,4],
                'list2' => [1,3,4],
                'result' => [1,1,2,3,4,4]
            ],
            [
                'list1' => [1],
                'list2' => [],
                'result' => [1]
            ],
            [
                'list1' => [1],
                'list2' => [1,3,4],
                'result' => [1]
            ],
            [
                'list1' => [5],
                'list2' => [1, 2, 4],
                'result' => [1, 2, 4, 5]
            ],
        ];
        foreach ($data as $j => $dataset) {
            echo 'Dataset' . ($j + 1) . PHP_EOL;
            foreach (
                [
                    Solution::STRATEGY_CUT_OFF,
                    Solution::STRATEGY_RECURSION,
                    null
                ] as $strategy
            ) {
                foreach (['list1', 'list2'] as $name) {
                    for ($i = count($dataset[$name]) - 1; $i >= 0; $i--) {
                        ${$name} = new ListNode($dataset[$name][$i], ${$name} ?? null, $name);
                    }
                    if (!isset(${$name})) {
                        ${$name} = new ListNode(null, null, $name);
                    }
                }

                $merged = (new Solution($strategy))->mergeTwoLists($list1, $list2);
                while ($merged) {
                    echo '[' . $merged->name . ': ' . $merged->val . '] ';
                    $merged = $merged->next;
                }
                unset($list1, $list2);
            }
            echo PHP_EOL;
        }
    }
}
