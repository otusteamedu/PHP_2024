<?php

declare(strict_types=1);

namespace Rmulyukov\Hw6;

use function checkdnsrr;
use function preg_match;

final class EmailValidator
{
    private const TYPE_REGEX = 1;
    private const TYPE_MX = 2;

    private string $regex = "#^[-a-z0-9!$%&'*+/=?^_`{|}~]+(?:\.[-a-z0-9!$%&'*+/=?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)*(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|[a-z][a-z])$#";

    public function regExValidate(string $email, string ...$emails): array
    {
        return $this->check(self::TYPE_REGEX, $email, ...$emails);
    }

    public function mxValidate(string $email, string ...$emails): array
    {
        return $this->check(self::TYPE_MX, $email, ...$emails);
    }

    private function check(int $type, string ...$emails): array
    {

        $result = [];
        foreach ($emails as $email) {
            switch ($type) {
                case self::TYPE_REGEX:
                    $result[$email] = (bool) preg_match($this->regex, $email);
                    break;

                case self::TYPE_MX:
                    $parts = explode("@", $email);
                    $result[$email] = checkdnsrr(array_pop($parts), 'mx');
            }
        }
        return $result;
    }
}
