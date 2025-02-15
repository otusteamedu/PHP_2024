<?php
namespace App;

class VerifyEmail {
    public function validateEmailFormat($email) {
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        return preg_match($pattern, $email);
    }

    public function checkMxRecords($email) {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, 'MX');
    }

    public function validateEmail($email) {
        if (!$this->validateEmailFormat($email)) {
            return false;
        }

        if (!$this->checkMxRecords($email)) {
            return false;
        }

        return true;
    }

    public function verifyEmails($emailList) {
        $validEmails = [];
        $invalidEmails = [];

        foreach ($emailList as $email) {
            if ($this->validateEmail($email)) {
                $validEmails[] = $email;
            } else {
                $invalidEmails[] = $email;
            }
        }

        return [
            'valid' => $validEmails,
            'invalid' => $invalidEmails
        ];
    }
}