<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Factory\Notification;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Viking311\Queue\Infrastructure\Config\Config;
use Viking311\Queue\Infrastructure\Notification\Mail;

class MailFactory
{
    /**
     * @throws Exception
     */
    public static function createInstance(): Mail
    {
        $config = new Config();

        $mailer = new PHPMailer(true);
        $mailer->isSMTP();
        $mailer->Host = $config->mail->host;
        $mailer->Port = $config->mail->port;
        $mailer->setFrom(
            $config->mail->fromEmail,
            $config->mail->fromName
        );
        if (!empty($config->mail->user) && !empty($config->mail->password)) {
            $mailer->SMTPAuth = true;
            $mailer->Username = $config->mail->user;
            $mailer->Password = $config->mail->password;
        }

        return new Mail($mailer);
    }
}
