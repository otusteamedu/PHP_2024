<?php

namespace EmailVerifier;

class EmailChecker
{
    /**
     * Проверяет список email-адресов.
     *
     * @param array $emails
     * @return array
     */
    public function checkEmails(array $emails): array
    {
        $results = [];
        foreach ($emails as $email) {
            $isValid = EmailVerifier::isValidEmail($email);
            $exists = $isValid && EmailVerifier::verifyMailboxExists($email);

            $results[] = [
                'email' => $email,
                'valid' => $isValid,
                'exists' => $exists
            ];
        }

        return $results;
    }
}
