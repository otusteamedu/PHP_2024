<?php

declare(strict_types=1);

include_once("task1.php");
include_once("task2.php");

// Test cases for the hasCycle function
function runTestsTask1(): void
{
    echo "Test Task1 " . PHP_EOL;
    $testCases = [
        'No Cycle' => function() {
            // Create a linked list: 1->2->3->4->null
            $head = new ListNode(1);
            $head->next = new ListNode(2);
            $head->next->next = new ListNode(3);
            $head->next->next->next = new ListNode(4);

            $solution = new SolutionTask1();
            $result = $solution->hasCycle($head);

            echo "Test Case 1 (No Cycle): " . ($result === false ? "PASSED" : "FAILED") . "\n";
        },

        'With Cycle' => function() {
            // Create a linked list with cycle: 1->2->3->4->2
            $head = new ListNode(1);
            $node2 = new ListNode(2);
            $head->next = $node2;
            $head->next->next = new ListNode(3);
            $head->next->next->next = new ListNode(4);
            $head->next->next->next->next = $node2; // Creates cycle back to node 2

            $solution = new SolutionTask1();
            $result = $solution->hasCycle($head);

            echo "Test Case 2 (With Cycle): " . ($result === true ? "PASSED" : "FAILED") . "\n";
        },

        'Single Node No Cycle' => function() {
            // Create a single node linked list: 1->null
            $head = new ListNode(1);

            $solution = new SolutionTask1();
            $result = $solution->hasCycle($head);

            echo "Test Case 3 (Single Node No Cycle): " . ($result === false ? "PASSED" : "FAILED") . "\n";
        }
    ];

    // Run all test cases
    foreach ($testCases as $name => $test) {
        $test();
    }
}


/**
 * Test cases for letterCombinations function
 */
function runTestsTask2(): void
{
    $solution = new SolutionTask2();

    $testCases = [
        [
            'input' => '23',
            'expected' => ['ad', 'ae', 'af', 'bd', 'be', 'bf', 'cd', 'ce', 'cf'],
            'name' => 'Two digits'
        ],
        [
            'input' => '',
            'expected' => [],
            'name' => 'Empty string'
        ],
        [
            'input' => '2',
            'expected' => ['a', 'b', 'c'],
            'name' => 'Single digit'
        ]
    ];
    echo "Test Task2 " . PHP_EOL;
    foreach ($testCases as $index => $test) {
        $result = $solution->letterCombinations($test['input']);
        $passed = $result === $test['expected'];
        echo "Test Case " . ($index + 1) . " ({$test['name']}): " .
            ($passed ? "PASSED" : "FAILED") . "\n";

        if (!$passed) {
            echo "  Expected: " . json_encode($test['expected']) . "\n";
            echo "  Got: " . json_encode($result) . "\n";
        }
    }
}

// Run the tests
runTestsTask1();
runTestsTask2();