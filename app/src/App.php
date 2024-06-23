<?php

namespace Otus\Hw8;

class App
{
    /** @var string|null */
    private ?string $message;

    /** @var array */
    private array $errors = [];

    /** @var array|null */
    private ?array $arg1;

    /** @var array|null */
    private ?array $arg2;

    /** @var ListNode|null */
    private ?ListNode $list1;

    /** @var ListNode|null */
    private ?ListNode $list2;

    /** @var ListNode|null */
    private ?ListNode $mergedList;

    public function __construct()
    {
        $this->setInputParams();
    }

    /**
     * @return void
     */
    private function setInputParams(): void
    {
        $arg1 = !empty($_SERVER['argv'][1]) && json_validate($_SERVER['argv'][1])
            ? json_decode($_SERVER['argv'][1], true)
            : null;

        $arg2 = !empty($_SERVER['argv'][2]) && json_validate($_SERVER['argv'][2])
            ? json_decode($_SERVER['argv'][2], true)
            : null;

        $this->arg1 = is_array($arg1) ? $arg1 : null;
        $this->arg2 = is_array($arg2) ? $arg2 : null;
    }

    /**
     * @return bool
     */
    private function checkInputParams(): bool
    {
        if (!isset($this->arg1)) {
            $this->addError('First input argument is required and must be an array!');
            return false;
        }

        if (!isset($this->arg2)) {
            $this->addError('Second input argument is required and must be an array!');
            return false;
        }

        if (count($this->arg1) > 50 || count($this->arg2) > 50) {
            $this->addError('The number of nodes in both lists is in the range [0, 50]!');
            return false;
        }

        if (!$this->checkListValues($this->arg1) || !$this->checkListValues($this->arg2)) {
            return false;
        }

        if (!$this->checkListSortOrder($this->arg1) || !$this->checkListSortOrder($this->arg2)) {
            return false;
        }

        return true;
    }

    /**
     * @param array $list
     * @return bool
     */
    private function checkListValues(array $list): bool
    {
        foreach ($list as $val) {
            if ($val < -100 || $val > 100) {
                $this->addError('The values of the input params must be in the range: -100 <= Node.val <= 100!');
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $list
     * @return bool
     */
    private function checkListSortOrder(array $list): bool
    {
        $length = count($list);

        if ($length <= 1) {
            return true;
        }

        for ($i = 1; $i < $length; $i++) {
            if ($list[$i] < $list[$i - 1]) {
                $this->addError('Both arg1 and arg2 must be sorted in non-decreasing order!');
                return false;
            }
        }

        return true;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        if ($this->checkInputParams()) {
            $this->setLists();
            $solution = new Solution();
            $this->mergedList = $solution->mergeTwoLists($this->list1, $this->list2);
        }

        $this->setMessage();
    }

    /**
     * @return void
     */
    private function setLists(): void
    {
        $this->list1 = $this->createSortedList($this->arg1);
        $this->list2 = $this->createSortedList($this->arg2);
    }

    /**
     * @param array|null $values
     * @return ListNode|null
     */
    private function createSortedList(?array $values): ?ListNode
    {
        if (empty($values)) {
            return null;
        }

        $dummy = new ListNode();
        $current = $dummy;

        foreach ($values as $val) {
            $current->next = new ListNode($val);
            $current = $current->next;
        }

        return $dummy->next;
    }

    /**
     * @return void
     */
    private function setMessage(): void
    {
        $this->message = $this->hasErrors()
            ? $this->getErrors()
            : $this->printList($this->mergedList);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param ListNode|null $head
     * @return string
     */
    private function printList(?ListNode $head): string
    {
        $result = [];
        $current = $head;
        while ($current !== null) {
            $result[] = $current->val . ' ';
            $current = $current->next;
        }

        return '[' . implode(',', $result) . ']' . PHP_EOL;
    }

    /**
     * @return bool
     */
    private function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @param string $message
     * @return void
     */
    private function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    /**
     * @return string
     */
    private function getErrors(): string
    {
        $result = '';
        foreach ($this->errors as $error) {
            $result .= $error . PHP_EOL;
        }

        return $result;
    }
}
