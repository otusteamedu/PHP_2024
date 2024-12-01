<?php
 
use PhpAmqpLib\Message\AMQPMessage;
require_once 'QueueManager.php';

$queueManager = new QueueManager();

 
$callback = function(AMQPMessage $msg) {
    $task = json_decode($msg->getBody(), true);
    echo "Обрабатываем запрос на генерацию выписки для дат: {$task['start_date']} - {$task['end_date']}.\n";
    echo "Email: {$task['email']}\n";
    
 
    sleep(1);  

  
    mail($task['email'], 'Ваш запрос обработан', 'Ваш запрос на выписку за указанные даты готов.');

 
    echo "Задача обработана, уведомление отправлено на email: {$task['email']}\n";
};

 
$queueManager->getQueue()->basic_consume('task_queue', '', false, true, false, false, $callback);
 
while($queueManager->getQueue()->is_consuming()) {
    $queueManager->getQueue()->wait();
}

$queueManager->close();
