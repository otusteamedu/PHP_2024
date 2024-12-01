<?php
require_once 'src/QueueManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $email = $_POST['email'];

    // Добавляем запрос в очередь
    $queueManager = new QueueManager();
    $queueManager->addToQueue(['start_date' => $startDate, 'end_date' => $endDate, 'email' => $email]);

    echo 'Ваш запрос принят в обработку. Ожидайте уведомление по завершению.';
}
