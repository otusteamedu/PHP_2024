<?php

declare(strict_types=1);

namespace Services;

use Exception;

class Email
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        if (! file_exists($filePath))
            throw new Exception("File not found: {$filePath}");
        $this->filePath = $filePath;
    }

    public function getEmails(): array
    {
        return array_filter(array_map('trim', file($this->filePath)));
    }

    public function isValid(): array
    {
        $result = [];
        $emailList = $this->getEmails();

        foreach ($emailList as $email) {
            $isEmailRegexp = (is_string($email)) ? $this->checkRegexp($email) : false;
            $isEmailMX = (is_string($email)) ? $this->checkMX($email) : false;
            $result[$email] = [
                'isEmailRegexp' => $isEmailRegexp,
                'isEmailMX' => $isEmailMX
            ];
        }

        return $result;
    }

    public function getReadableResult(): void
    {
        $validResult = $this->isValid();

        echo '<pre>';
        var_export($validResult);
        echo '</pre>';
    }

    private function checkRegexp(string $email): bool
    {
        return (preg_match("~([a-zA-Z0-9!#$%&'*+-/=?^_`{|}])@([a-zA-Z0-9-]).([a-zA-Z0-9]{2,4})~", $email)) ? true : false;
    }

    private function checkMX(string $email): bool
    {
        $emailArray = explode('@', $email);
        $hostname = end($emailArray);

        return getmxrr($hostname, $mxhosts);
    }
}
