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
        $emails = $_SERVER['argv'] ?? [];

        foreach ($emails as $key => $email) {
            if ($key === 0) {
                continue;
            }

            if (!$this->validatorEmailName->validate($email)) {
                throw new \Exception("Email $email is not valid");
            }

            if (!$this->validatorEmailDns->validate($email)) {
                throw new \Exception("DNS email $email is not valid");
            }
        }
    }
}
