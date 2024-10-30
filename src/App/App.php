<?php

namespace VSukhov\Hw13\App;

class App
{
    public function run(): void
    {
        $this->solutionOne();
        $this->solutionTwo();
    }

    /**
     * Сложность по времени: O(3^n * 4^m), где n — количество цифр, соответствующих 3 буквам, а m — количество цифр, соответствующих 4 буквам.
     * Сложность по памяти: O(3^n * 4^m), нужно хранить все комбинации.
     */
    private function solutionOne(): void
    {
        $node1 = new NodeList(3);
        $node2 = new NodeList(2);
        $node3 = new NodeList(0);
        $node4 = new NodeList(-4);

        $node1->next = $node2;
        $node2->next = $node3;
        $node3->next = $node4;
        $node4->next = $node2;

        $solution = new LinkedListSolution();
        $result = $solution->hasCycle($node1);

        echo $result ? "Циклично\n" : "Не циклично\n";
    }

    /**
     * Сложность по времени: O(n)
     * Сложность по памяти: O(1)
     */
    private function solutionTwo(): void
    {
        $digits = '23';
        $solution = new CombinationsSolution();
        $combinations = $solution->letterCombinations($digits);

        echo "Комбинации для : $digits:\n";
        print_r($combinations);
    }
}
