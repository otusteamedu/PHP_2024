<?php

require __DIR__ . '/vendor/autoload.php';

$service = new Stasya0903\NounDeclension\NounDeclension();
$service->setTitles('курс', 'курса', 'курсов');

for ($i = 1; $i <= 100; $i++) {
    echo $service->declineByNumber($i) . PHP_EOL;
}
