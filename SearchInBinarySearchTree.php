<?php

/**
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($val = 0, $left = null, $right = null) {
 *         $this->val = $val;
 *         $this->left = $left;
 *         $this->right = $right;
 *     }
 * }
 */
class Solution
{

    /**
     * @param TreeNode $root
     * @param Integer $val
     * @return TreeNode
     */
    function searchBST($root, $val)
    {
        // базовый случай
        if ($root === null || $root->val == $val) {
            return $root;
        }

        // рекурсивный случай
        $left = $this->searchBST($root->left, $val);
        $right = $this->searchBST($root->right, $val);

        return $left ?? $right;
    }
}