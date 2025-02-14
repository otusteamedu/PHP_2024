<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Service\BankStatementMailerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class Mailer implements BankStatementMailerInterface
{
    public function __construct(
        private MailerInterface       $mailer,
        private ParameterBagInterface $env
    )
    {
    }

    public function sendBankStatement(array $bankStatements): void
    {
        $bankStatementsString = nl2br(print_r($bankStatements, true));

        $email = (new Email())
            ->from($this->env->get('emailFrom'))
            ->to('alexey.mikha1lov@yandex.ru')
            ->subject('Выписка')
            ->html('Ваша выписка готова:<br><br>' . $bankStatementsString);

        $this->mailer->send($email);
    }
}
