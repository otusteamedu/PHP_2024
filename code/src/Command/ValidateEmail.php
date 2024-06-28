<?php

declare(strict_types=1);

namespace Viking311\EmailChecker\Command;

use Exception;
use Viking311\EmailChecker\Response\Response;
use Viking311\EmailChecker\Validator\EmailFormat;
use Viking311\EmailChecker\Validator\EmailMx;
use Viking311\EmailChecker\Validator\ValidationChain;

class ValidateEmail
{
    /**
     * @param array $emails
     * @param Response $response
     * @return void
     */
    public function run(array $emails, Response $response): void
    {
        $validationChain = new ValidationChain();
        $validationChain->addValidator(
            new EmailFormat()
        )
        ->addValidator(new EmailMx());

        $result = '';

        foreach ($emails as $email) {
            $validationChain->setData($email);
            try {
                $validationChain->validate();
                $result .= $email . ' - valid <br />';
            } catch (Exception $ex) {
                $result .= $email . ' - ' . $ex->getMessage() . '<br />';
            }
        }

        $response->setContent($result);
    }
}
