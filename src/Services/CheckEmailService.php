<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Services;

use Exception;
use RailMukhametshin\Hw\Validators\EmailDnsMxValidator;
use RailMukhametshin\Hw\Validators\EmailRegxValidator;

class CheckEmailService
{
    public function selectValidEmails(array $emails): array
    {
        $result = [];

        $regxValidator = new EmailRegxValidator();
        $dnsMxValidator = new EmailDnsMxValidator();

        foreach ($emails as $email) {
            if ($regxValidator($email) && $dnsMxValidator($email)) {
                $result[] = $email;
            }
        }

        return $result;
    }
}
