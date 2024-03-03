<?php
declare(strict_types=1);

namespace AlexSOtus\ComposerHomework;

class PartStringHighlight
{

    public function stringHighlight(string $string, string $partString): string {
        $check = str_contains($string, $partString);
        if ($check) {
            $array = explode($partString,$string);
            $implodeSep = "(" . $partString . ")";
            return implode($implodeSep,$array);
        }

        return "Подстрока " . $partString . " не содержится в строке " . $string;
    }

}