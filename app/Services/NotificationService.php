<?php

namespace App\Services;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class NotificationService
{
    public function sendEmail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = getenv('EMAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('EMAIL_USERNAME');
            $mail->Password = getenv('EMAIL_PASSWORD');
            $mail->SMTPSecure = 'tls';
            $mail->Port = getenv('EMAIL_PORT');

            $mail->setFrom(getenv('EMAIL_FROM'), 'Queue App');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
        } catch (Exception $e) {
            echo "Не удалось отправить email: {$e->getMessage()}";
        }
    }

    public function sendTelegram($message): void
    {
        $apiKey = getenv('TELEGRAM_API_KEY');
        $chatId = getenv('TELEGRAM_CHAT_ID');
        $url = "https://api.telegram.org/bot$apiKey/sendMessage?chat_id=$chatId&text=" . urlencode($message);

        file_get_contents($url);
    }
}
