<?php

use AlexanderPogorelov\Algorithm2\FractionService;
use AlexanderPogorelov\Algorithm2\IntersectedNodeDetector;
use AlexanderPogorelov\Algorithm2\ListNodeCreator;

require __DIR__ . '/vendor/autoload.php';

$dto = ListNodeCreator::createIntersectedListNodes([4,1,8,4,5], [5,6,1,8,4,5], 2, 3);
var_dump((new IntersectedNodeDetector())->getIntersectionNode($dto->headA, $dto->headB));
echo '--------------------------------------------------------------------------------------------' . PHP_EOL;

$dto = ListNodeCreator::createIntersectedListNodes([1,9,1,2,4], [3,2,4], 3, 1);
var_dump((new IntersectedNodeDetector())->getIntersectionNode($dto->headA, $dto->headB));
echo '--------------------------------------------------------------------------------------------' . PHP_EOL;

$dto = ListNodeCreator::createIntersectedListNodes([2,6,4], [1,5], 3, 2);
var_dump((new IntersectedNodeDetector())->getIntersectionNode($dto->headA, $dto->headB));
echo '--------------------------------------------------------------------------------------------' . PHP_EOL;


$dto = ListNodeCreator::createIntersectedListNodes([1,2], [2,2], 1, 1);
var_dump((new IntersectedNodeDetector())->getIntersectionNode($dto->headA, $dto->headB));
echo '--------------------------------------------------------------------------------------------' . PHP_EOL;


$dto = ListNodeCreator::createIntersectedListNodes([10], [10], 0, 0);
var_dump((new IntersectedNodeDetector())->getIntersectionNode($dto->headA, $dto->headB));
echo '--------------------------------------------------------------------------------------------' . PHP_EOL;

var_dump((new FractionService())->fractionToDecimal(0, 2));
var_dump((new FractionService())->fractionToDecimal(1, 2));
var_dump((new FractionService())->fractionToDecimal(2, 1));
var_dump((new FractionService())->fractionToDecimal(40, 2));
var_dump((new FractionService())->fractionToDecimal(4, 333));
var_dump((new FractionService())->fractionToDecimal(-26, 15));
var_dump((new FractionService())->fractionToDecimal(7, -12));
var_dump((new FractionService())->fractionToDecimal(45, 11));
var_dump((new FractionService())->fractionToDecimal(41, 99));
