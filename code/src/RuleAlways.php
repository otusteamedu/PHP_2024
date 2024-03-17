<?php

namespace IraYu\OtusHw4;

class RuleAlways implements Rule
{
    public function check(Request $request): bool
    {
        return true;
    }
}

