<?php

declare(strict_types=1);

namespace App;

use App\Services\EmailVerificationService\EmailVarificator;
use App\Services\EmailVerificationService\Exceptions\EmailValidateException;

class Base
{
    /**
     * @param array $emails
     * @return array|null
     * @throws EmailValidateException
     */
    public function run(array $emails): ?array
    {
        $varified_emails = new EmailVarificator($emails);
        return $varified_emails->emailsVarify();
    }
}
