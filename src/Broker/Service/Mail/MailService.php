<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Service\Mail;

use Symfony\Component\Mailer\Bridge\Google\Transport\GmailTransportFactory;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailService
{
    private Mailer $mailer;

    public function __construct(string $gmailTransportDsn)
    {
        $dsn = Dsn::fromString($gmailTransportDsn);
        $transport = (new GmailTransportFactory())->create($dsn);
        $this->mailer = new Mailer($transport);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMessageSuccessfullyProcessedLetter(string $email, string $messageText): void
    {
        $text = <<<HTML
Ваше сообщение успешно обработано. <br>
Сообщение: $messageText        
HTML;

        $letter = (new Email())
            ->from('box@application.local')
            ->to($email)
            ->subject('Сообщение успешно обработано')
            ->html($text);

        $this->mailer->send($letter);
    }
}
