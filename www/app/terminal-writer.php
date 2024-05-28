<?php

declare(strict_types=1);

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

error_reporting(E_ALL ^ E_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

$rabbit = new \Common\RabbitWrapper();
$rabbit->initQueue();

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$mailer = null;

while (true) {
    try {
        $message = $rabbit->getMessageOrNull();
        if ($message) {
            echo $message->message . PHP_EOL;
            if ($message->notify) {
                try {
                    if (!$mailer) {
                        $mailer = new \Common\MailerWrapper();
                    }
                    $mailer->send($message->email, "Process for $message->user finished", $message->message);
                } catch (TransportExceptionInterface $exception) {
                    echo $exception->getMessage() . PHP_EOL;
                }
            }
        }
    } catch (\Throwable $exception) {
        echo $exception->getMessage();
        break;
    }
    usleep(250_000);
}
