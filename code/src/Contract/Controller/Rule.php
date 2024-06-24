<?php

namespace IraYu\Contract\Controller;

use IraYu\Contract;

interface Rule
{
    public function check(\IraYu\Contract\Request $request): bool;
}
