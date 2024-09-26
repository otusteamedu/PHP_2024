<?php

declare(strict_types=1);

namespace Evgenyart\ElasticHomework;

class Helpers
{
    public static function myMbStrPad(
        string $string,
        int $length,
        string $pad_string = " ",
        int $pad_type = STR_PAD_RIGHT,
        string | null $encoding = null
    ) {
        $padding = '';
        $paddingLength = $length - mb_strlen($string, $encoding);
        while (($l = mb_strlen($padding, $encoding)) < $paddingLength) {
            // build padding string 1 $pad_string at a time until the desired $paddingLength is reached
            $padding .= mb_substr($pad_string, 0, $paddingLength - $l, $encoding);
        }
        return match ($pad_type) {
            STR_PAD_RIGHT => $string . $padding,
            STR_PAD_LEFT => $padding . $string,
            STR_PAD_BOTH =>
            mb_substr($padding, 0, ceil(mb_strlen($padding, $encoding) / 2)) .
                $string .
                mb_substr($padding, 0, floor(mb_strlen($padding, $encoding) / 2)),
        };
    }
}
