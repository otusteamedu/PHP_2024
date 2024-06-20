<?php

declare(strict_types=1);

namespace Orlov\Otus\Mail;

class Mailer
{
    private \PHPMailer $mail;

    public function __construct(private readonly string $body)
    {
        $this->mail = new \PHPMailer(true);
        $this->init();
    }

    private function init()
    {
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['EMAIL_SMTP'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['EMAIL_USER'];
        $this->mail->Password = $_ENV['EMAIL_PASSWORD'];
        $this->mail->Port = $_ENV['EMAIL_PORT'];

        $this->mail
            ->setFrom($_ENV['EMAIL_FROM'], 'Sender')
            ->addAddress($_ENV['EMAIL_TO'], 'Recipient');

        $this->mail->Subject = 'Новое сообщение';
        $this->mail->Body = $this->body;
    }
    public function send(): void
    {
        try {
            $this->mail->send();
        } catch (Exception $e) {
            echo 'Ошибка отправки письма: ' . $this->mail->ErrorInfo;
        }
    }
}
