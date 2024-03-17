<?php

namespace IraYu\OtusHw4;

interface Rule
{
    public function check(Request $request): bool;
}