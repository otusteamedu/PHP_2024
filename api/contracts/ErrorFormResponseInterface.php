<?php

declare(strict_types=1);

namespace api\contracts;

interface ErrorFormResponseInterface
{
    /**
     * @param null $attribute
     * @return bool
     */
    public function hasErrors($attribute = null);

    /**
     * @return array
     */
    public function getFirstErrors();
}
