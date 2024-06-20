<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Tbublikova\OtusChZodiac\ChineseZodiac;

$zodiac = new ChineseZodiac();
$year = 2024;
echo "The Chinese Zodiac sign for the year {$year} is: " . $zodiac->getZodiac($year);
