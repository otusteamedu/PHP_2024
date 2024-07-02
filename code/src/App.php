<?php

namespace TBublikova\Php2024;

class App
{
    /**
     * @return array<int, int|string>
     */
    public function run(): array
    {
        return (new RequestHandler())->handle($_POST);
    }
}
