<?php

namespace Pavelsergeevich\Hw6\Models;

use Pavelsergeevich\Hw6\Core\Model;

class EmailModel extends Model
{

    public function checkEmailValidation(): array
    {
        if (!$this->requestParams['all']['email']) {
            return [
                'isSuccess' => false,
                'data' => []
            ];
        }

        $email = $this->requestParams['all']['email'];
        $isValidRegex = $this->isValidRegexEmail($email);

        $dnsMxByEmail = $isValidRegex ? $this->getDnsMxByEmail($email) : ['isSuccess' => false];

        $isValidAll = $isValidRegex && $dnsMxByEmail['isSuccess'];
        return [
            'isSuccess' => true,
            'data' => [
                'email' => $email,
                'isRegexValid' => $isValidRegex,
                'isDnsValid' => $dnsMxByEmail['isSuccess'],
                'dnxMxList' => $dnsMxByEmail['dnsMxList'] ?? [],
                'isAllValid' => $isValidAll
            ]
        ];
    }

    private function isValidRegexEmail(string $email): bool
    {
        return (preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email));
    }

    private function getDnsMxByEmail(string $email): array
    {

        $emailDomain = mb_substr($email, strripos($email, '@') + 1);

        $hosts = [];
        $weights = [];
        $result = getmxrr($emailDomain, $hosts, $weights);

        if (!$result) {
            return [
                'isSuccess' => false,
                'dnsMxList' => []
            ];
        } else {
            $dnsMxList = [];
            foreach ($hosts as $key => $host) {
                $dnsMxList[$weights[$key]] = $host;
            }
            krsort($dnsMxList);
            return [
                'isSuccess' => true,
                'dnsMxList' => $dnsMxList
            ];
        }
    }
}
