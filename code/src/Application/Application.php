<?php

declare(strict_types=1);

namespace Viking311\EmailChecker\Application;

use Viking311\EmailChecker\Command\ValidateEmail;
use Viking311\EmailChecker\Response\Response;

class Application
{
    public function run(array $emails): Response
    {
        $response = new Response();

        $cmd = new ValidateEmail();
        $cmd->run($emails, $response);

        return $response;
    }
}
