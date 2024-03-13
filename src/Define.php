<?php

declare(strict_types=1);

namespace hw10;

class Define
{
    public function init($data)
    {
        if (empty($data)) {
            return null;
        }
        $first = array_shift($data);
        return new ListNode($first, $this->init($data));
    }
}
