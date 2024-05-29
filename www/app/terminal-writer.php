<?php

declare(strict_types=1);

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

error_reporting(E_ALL ^ E_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

$settings = \Common\Settings::buildFromEnvVars();

$rabbit = new \Common\RabbitWrapper(
    $settings->rabbitmqQueueName,
    new AMQPStreamConnection($settings->rabbitmqHost, $settings->rabbitmqPort, $settings->rabbitmqUser, $settings->rabbitmqPass)
);

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
                        $mailer = new \Common\MailerWrapper(
                            $settings->smtpUser,
                            new Mailer(Transport::fromDsn(
                                "smtp://" . $settings->smtpUser . ":" . $settings->smtpPass . "@" . $settings->smtpHost . ":" . $settings->smtpPort
                            ))
                        );
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
