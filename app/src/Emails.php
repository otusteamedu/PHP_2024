<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App;

use AnatolyShilyaev\App\Pattern;

class Emails
{
    public function extract($inputString): array
    {
        $pattern = (new Pattern)->getPattern();

        preg_match_all($pattern, $inputString, $matches);

        return $matches[0];
    }
}
