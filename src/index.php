<?php

declare(strict_types=1);

use AnatolyShilyaev\MyComposerPackage\BadRequestException;

$string = $_POST['name'];


if ($string[0] !== "(" || $string[mb_strlen($string) - 1] !== ")") {
    throw new BadRequestException('Wrong request');
}

// for ($i = 0; $i < mb_strlen($string); $i++) {
//     if ($string[$i] === "(") {
//         for ($j = $i + 1; $j < mb_strlen($string); $j++) {
//             if ($string[$j] === ")") {
//                 $sdf = substr($string, 0, $position) . substr($string, $position + 1);
//             }
//         }
//     }
//     echo $string[$i] . "<br>";
// }

// $string=(()()()()))((((()()()))(()()()(((()))))))
// $string=(()()()()))((((()()()))(()()()(((()))))))