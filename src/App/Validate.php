<?php

declare(strict_types=1);

namespace Komarov\Hw4;

class Validate
{
    /**
     * @return bool
     */
    public function checkStringBrackets(): bool
    {
        $result = false;

        if (!empty($_POST['string'])) {
            $regExp = '/^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$/m';
            preg_match($regExp, $_POST['string'], $matches);
            $result = count($matches) !== 0;
        }

        return $result;
    }
}
