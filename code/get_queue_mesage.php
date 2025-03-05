<?php

declare(strict_types=1);

use Asyrovatkin\Hw19\Infrastructure\RabbitConnect;

require __DIR__ . '/vendor/autoload.php';

$rabbit = new RabbitConnect();

$msq = $rabbit->getMsqFromQueue(RabbitConnect::QUEUE_NAME);

print (is_null($msq) ? 'Очередь пуста' : (empty($msq) ? 'Пустое сообщение' : $msq )) . PHP_EOL ;