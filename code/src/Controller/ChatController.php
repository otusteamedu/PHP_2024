<?php

namespace IraYu\Controller;

use IraYu\Contract;

class ChatController extends FrontController
{
    use Contract\Traits\Configurable;

    public function init(): void
    {
        $this
            ->addCommand(new RuleChatRole('server'), (new CommandStartServer())->setConfigs($this->getConfigs()))
            ->addCommand(new RuleChatRole('client'), (new CommandStartClient())->setConfigs($this->getConfigs()))
            ->addCommand(new RuleAlways(), new CommandShowHelp())
        ;
    }


}
