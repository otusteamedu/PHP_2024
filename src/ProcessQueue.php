<?php
require_once 'QueueManager.php';

$queueManager = new QueueManager();
$queue = $queueManager->getQueue();

foreach ($queue as $task) {
    echo "Обработка запроса для дат: {$task['start_date']} - {$task['end_date']} на email: {$task['email']}\n";
     
    sleep(1);  
     
    mail($task['email'], 'Ваш запрос обработан', 'Ваша банковская выписка за указанные даты готова.');

}
