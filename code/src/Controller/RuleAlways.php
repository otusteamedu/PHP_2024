<?php

namespace IraYu\Controller;

use IraYu\Contract;

class RuleAlways implements \IraYu\Contract\Controller\Rule
{
    public function check(\IraYu\Contract\Request $request): bool
    {
        return true;
    }
}
