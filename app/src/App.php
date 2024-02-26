<?php

namespace Dsergei\Hw6;

class App
{
    private ValidatorEmailName $validatorEmailName;

    private ValidatorEmailDns $validatorEmailDns;

    public function __construct()
    {
        $this->validatorEmailName = new ValidatorEmailName();
        $this->validatorEmailDns = new ValidatorEmailDns();
    }
    /**
     * @throws \Exception
     */
    public function run(): void
    {
        global $argv;

        foreach ($argv as $key => $email) {
            if ($key === 0)
            {
                continue;
            }

            $this->validatorEmailName->validate($email);
            $this->validatorEmailDns->validate($email);
        }
    }
}
