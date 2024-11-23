<?php

namespace SergeyShirykalov\OtusBracketsChecker;

class Normalizer
{
    /**
     * Удаляет все символы из строки, кроме скобок
     *
     * @param string $str
     * @return string
     */
    public static function normalize(string $str): string
    {
        return preg_replace('/[^()]/', '', $str);
    }
}
