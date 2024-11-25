<?php

require __DIR__ . '/vendor/autoload.php';

use Alver\ComposerPackage\ParenthesesStringValidator;

$validString = "(()(()))";
$invalidString = "(()))(()";

if (ParenthesesStringValidator::validate($validString)) {
    echo "The string '$validString' is valid.\n";
} else {
    echo "The string '$validString' is invalid.\n";
}

if (ParenthesesStringValidator::validate($invalidString)) {
    echo "The string '$invalidString' is valid.\n";
} else {
    echo "The string '$invalidString' is invalid.\n";
}