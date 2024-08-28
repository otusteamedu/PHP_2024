<?php

declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';

use MukhametaliKussaiynov\OtusComposerPackage\PalindromeChecker;

$checker = new PalindromeChecker();
$string = "A man, a plan, a canal, Pwwanama";
echo $checker->isPalindrome($string) ? "Palindrome" : "Not a palindrome";
echo PHP_EOL;