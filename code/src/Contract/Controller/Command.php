<?php

namespace IraYu\Contract\Controller;

use IraYu\Contract;

interface Command
{
    public function execute(\IraYu\Contract\Request $request): void;
}
