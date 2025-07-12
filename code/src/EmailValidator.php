<?php

namespace VKomar;

class EmailValidator
{
    private array $emails;
    private array $validEmails = [];

    public function __construct()
    {
        $this->emails = $this->getEmails();
    }

    /**
     * @return array
     */
    private function getEmails(): array
    {
        $params = $_GET['emails'];

        if (empty($params)) {
            return [];
        }

        if (is_string($params)) {
            return explode(';', $params);
        }

        return [];
    }

    /**
     * @return array
     */
    public function checkEmails(): array
    {
        if (empty($this->emails)) {
            return [];
        }

        foreach ($this->emails as $email) {
            if ($this->validateEmail($email) && $this->validateMX($email)) {
                $this->validEmails[] = $email;
            }
        }
        return $this->validEmails;
    }

    /**
     * @param $email
     * @return bool
     */
    private function validateEmail($email): bool
    {
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param $email
     * @return bool
     */
    private function validateMX($email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain);
    }
}
