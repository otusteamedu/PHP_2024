<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Domain\Entity\BankStatementData;
use App\Application\Services\NotificationInterface;

class NotificationService implements NotificationInterface
{
    public function send(BankStatementData $data)
    {
        //реализация отправки почты, например, примитивно через функцию mail
        print_r("Письмо отправлено" . PHP_EOL);
    }
}
