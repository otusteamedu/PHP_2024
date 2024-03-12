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
    public function run(): bool
    {
        $emails = $_SERVER['argv'] ?? [];

        foreach ($emails as $key => $email) {
            if ($key === 0) {
                continue;
            }

            if (!$this->validatorEmailName->validate($email)) {
                return false;
            }

            if (!$this->validatorEmailDns->validate($email)) {
                return false;
            }
        }

        return true;
    }
}
