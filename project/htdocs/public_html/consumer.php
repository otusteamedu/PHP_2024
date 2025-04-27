<?php
require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

try {
    // Подключение к RabbitMQ
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    // Объявление очереди
    $queue = 'statement_requests';
    $channel->queue_declare($queue, false, true, false, false);

    echo " [*] Waiting for messages. To exit press CTRL+C\n";

    // Инициализация Telegram Bot
    $telegramBotToken = getenv('5629369317:AAESEdW5bjumxWWtVw_cADYXzEb72dgGPSc');
    $telegramChatId = getenv('536180558'); //
    $telegram = new Api($telegramBotToken);

    // Callback для обработки сообщений
    $callback = function ($msg) use ($telegram, $telegramChatId) {
        $data = json_decode($msg->body, true);
        $logMessage = "Received request:\n";
        $logMessage .= "  Start Date: {$data['start_date']}\n";
        $logMessage .= "  End Date: {$data['end_date']}\n";
        $logMessage .= "  Timestamp: {$data['timestamp']}\n";
        echo " [x] $logMessage";

        // Формирование сообщения для Telegram
        $telegramMessage = "New Statement Request:\n";
        $telegramMessage .= "Start Date: {$data['start_date']}\n";
        $telegramMessage .= "End Date: {$data['end_date']}\n";
        $telegramMessage .= "Timestamp: {$data['timestamp']}\n";

        // Логирование перед отправкой
        error_log($logMessage, 3, '/var/www/html/public_html/consumer.log');

        // Отправка сообщения в Telegram с повторной попыткой
        try {
            $telegram->sendMessage([
                'chat_id' => $telegramChatId,
                'text' => $telegramMessage
            ]);
            $successLog = "Sent to Telegram: Chat ID {$telegramChatId}\n";
            echo " [x] $successLog";
            error_log($successLog, 3, '/var/www/html/public_html/consumer.log');
        } catch (TelegramSDKException $e) {
            $errorLog = "Telegram Error: {$e->getMessage()}\n";
            echo " [x] $errorLog";
            error_log($errorLog, 3, '/var/www/html/public_html/consumer.log');

            // Повторная попытка через 5 секунд
            sleep(5);
            try {
                $telegram->sendMessage([
                    'chat_id' => $telegramChatId,
                    'text' => $telegramMessage
                ]);
                $retrySuccessLog = "Sent to Telegram on retry: Chat ID {$telegramChatId}\n";
                echo " [x] $retrySuccessLog";
                error_log($retrySuccessLog, 3, '/var/www/html/public_html/consumer.log');
            } catch (TelegramSDKException $retryException) {
                $retryErrorLog = "Telegram Retry Failed: {$retryException->getMessage()}\n";
                echo " [x] $retryErrorLog";
                error_log($retryErrorLog, 3, '/var/www/html/public_html/consumer.log');
            }
        }

        echo " [x] Done\n";

        // Подтверждение обработки сообщения
        $msg->ack();
    };

    // Настройка потребления сообщений
    $channel->basic_qos(null, 1, null);
    $channel->basic_consume($queue, '', false, false, false, false, $callback);

    // Ожидание сообщений
    while ($channel->is_consuming()) {
        $channel->wait();
    }

    // Закрытие соединений
    $channel->close();
    $connection->close();

} catch (Exception $e) {
    $errorLog = "Error: {$e->getMessage()}\n";
    echo $errorLog;
    error_log($errorLog, 3, '/var/www/html/public_html/consumer.log');
}