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
class Solution {

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function evaluateTree($root) {
        // базовый случай
        if ($root->left === null && $root->right === null) {
            return $root->val;
        }

        // рекурсивный случай
        if ($root->val == 2) { // OR
            return $this->evaluateTree($root->left) || $this->evaluateTree($root->right);
        } elseif ($root->val == 3) { // AND
            return $this->evaluateTree($root->left) && $this->evaluateTree($root->right);
        } else {
            return $root->val;
        }
    }
}