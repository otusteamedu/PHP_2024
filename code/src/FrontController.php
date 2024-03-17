<?php

namespace IraYu\OtusHw4;

class FrontController
{
    protected Request $request;
    protected array $commands = [];

    public function setRequest(Request $request): FrontController
    {
        $this->request = $request;

        return $this;
    }

    public function addCommand(Rule $rule, Command $command): FrontController
    {
        $this->commands[] = [$rule, $command];

        return $this;
    }

    public function resolve(): Response
    {
        /**
         * @var Rule $rule
         * @var Command $command
         */
        $response = new ResponseHTML();
        foreach ($this->commands as [$rule, $command]) {
            if ($rule->check($this->request)) {
                $result = $command->execute($this->request);
                $response->setResult($result);
                if (!$result->isSuccess()) {
                    break;
                }
            }
        }

        return $response;
    }
}
