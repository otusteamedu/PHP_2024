<?php

namespace PaymentServiceBundle\Domain\Service;

use Closure;
use PaymentServiceBundle\Application\Mailer\EmailSubjectEnum;
use PaymentServiceBundle\Controller\BundleUrlPrefixEnum\BundleUrlPrefixEnum;
use PaymentServiceBundle\Domain\Model\Email\EmailModel;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    private const SITE_URL_PREFIX = BundleUrlPrefixEnum::PaymentService->value;
    private const CONTROLLER_URL_PREFIX = BundleUrlPrefixEnum::LinkForShowReport->value;

    public function __construct(
        private readonly string $appSite,
        private readonly MailerInterface $mailer,
     ) {
    }

    public function emailHandler(EmailModel $emailModel): void
    {
        match ($emailModel->emailSubject) {
            EmailSubjectEnum::ReportCreated => $this->sendEmailAboutReportCreated($emailModel),
            default => $this->sendEmailAboutReportCreated($emailModel),
        };
    }

    public function sendEmailAboutReportCreated(EmailModel $emailModel): void
    {
        $linkForShowReport = 'http://' . $this->appSite . '/'
                            . self::SITE_URL_PREFIX
                            . self::CONTROLLER_URL_PREFIX
                            . $emailModel->uuid;

        $this->sendEmail(
            '@paymentServiceBundle/email/notification_mail.html.twig',
            'PaymentService: отчёт сформирован',
            $emailModel->email,
            '',
            ['text' => "Отчёт сформирован. Ссылка для просмотра отчёта: $linkForShowReport"]
        );
    }

    private function sendEmail(
        string $template,
        string $subject,
        string $email,
        string $firstName,
        ?array $context,
        Closure $callback = null
    ): void {
        $email = (new TemplatedEmail())
            ->from(new Address('mailer.jes@gmail.com', 'Mailer John' ))
            ->to(new Address($email, $firstName))
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context)
        ;

        if (is_callable($callback) ) {
            $callback($email);
        }

        $this->mailer->send($email);
    }
}
