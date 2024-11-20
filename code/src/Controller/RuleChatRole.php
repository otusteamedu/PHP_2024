<?php

namespace IraYu\Controller;

use IraYu\Contract;

class RuleChatRole implements \IraYu\Contract\Controller\Rule
{
    protected string $role;
    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function check(\IraYu\Contract\Request $request): bool
    {
        return $request->get('type') === $this->role;
    }
}
