<?php

namespace EmailVerifier;

class EmailVerifierFacade
{
    private EmailChecker $checker;
    private ResultFormatter $formatter;

    public function __construct()
    {
        $this->checker = new EmailChecker();
        $this->formatter = new ResultFormatter();
    }

    /**
     * Основной метод для проверки email и форматирования результата.
     *
     * @param array $emails
     * @return string
     */
    public function verifyAndFormat(array $emails): string
    {
        $results = $this->checker->checkEmails($emails);
        return $this->formatter->format($results);
    }
}
