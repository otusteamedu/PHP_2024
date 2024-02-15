<?php
require_once __DIR__ . '/vendor/autoload.php';

use \Pavelsergeevich\DatetimePackage\CustomDateTime;

$customDateTime = new CustomDateTime();
$startWeek = $customDateTime->getStartWeek(CustomDateTime::FORMAT_MYSQL);

echo "Понедельник текущий недели: $startWeek";
?>