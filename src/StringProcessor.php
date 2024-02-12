<?php

declare(strict_types=1);

namespace AleksandrOrlov\Capitalize;

class StringProcessor
{
  /**
   * @param string $string
   * @return string
   */
    public function capitalize(string $string): string
    {
        return ucfirst($string);
    }
}
