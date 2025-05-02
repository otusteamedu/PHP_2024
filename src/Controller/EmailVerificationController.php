<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\EmailVerifier;

class EmailVerificationController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * Verify a list of emails
     *
     * @param array<string> $emails List of emails to verify
     * @return array<string, bool> Results with email as key and verification result as value
     */
    public function verifyEmails(array $emails): array
    {
        return $this->emailVerifier->verifyEmails($emails);
    }
}