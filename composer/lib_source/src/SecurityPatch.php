<?php declare(strict_types=1);

namespace Evgenysmrnv\Security;

class SecurityPatch
{
    public static function checkHttpHeader(string $header): string
    {
        return str_replace(' ', '-', $header);
    }
}