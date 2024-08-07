<?php

declare(strict_types=1);

namespace api\form;

use api\contracts\ErrorFormResponseInterface;

class MockErrorFormResponse implements ErrorFormResponseInterface
{
    public function hasErrors($attribute = null)
    {
        return false;
    }

    public function getFirstErrors()
    {
        return [];
    }
}
