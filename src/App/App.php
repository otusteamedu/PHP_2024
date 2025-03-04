<?php

namespace App;

class App
{
    public function run()
    {
//        $result = $this->taskNode();
        $result = $this->taskPhone();

        echo json_encode($result);
    }

    private function taskNode()
    {
        $taskNode = new TaskNode();
        $head = $taskNode->getHead();

        $hasCycle = TaskNode::hasCycle($head);

        return $hasCycle ? 'Yes' : 'No';
    }

    private function taskPhone()
    {
        $taskPhone = new TaskPhone();
        $combinations = $taskPhone->letterCombinations("2349");
        //23
        //array(9) { [0]=> string(2) "ad" [1]=> string(2) "ae" [2]=> string(2) "af" [3]=> string(2) "bd" [4]=> string(2) "be" [5]=> string(2) "bf" [6]=> string(2) "cd" [7]=> string(2) "ce" [8]=> string(2) "cf" }

        return $combinations;
    }
}