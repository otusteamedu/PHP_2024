<?php

namespace IraYu\Controller;

use IraYu\Contract;

abstract class FrontController
{
    protected Contract\Request $request;
    protected array $commands = [];

    abstract protected function init(): void;

    public function setRequest(Contract\Request $request): FrontController
    {
        $this->request = $request;

        return $this;
    }

    public function addCommand(Contract\Controller\Rule $rule, Contract\Controller\Command $command): FrontController
    {
        $this->commands[] = [$rule, $command];

        return $this;
    }

    public function resolve(): void
    {
        /**
         * @var Contract\Controller\Rule $rule
         * @var Contract\Controller\Command $command
         */
        foreach ($this->commands as [$rule, $command]) {
            if ($rule->check($this->request)) {
                $command->execute($this->request);
                break;
            }
        }
    }
}
