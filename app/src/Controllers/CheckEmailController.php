<?php

declare(strict_types=1);

namespace IgorKachko\CheckEmail\Controllers;

use IgorKachko\OtusComposerPackage\EmailValidator;

class CheckEmailController
{
    public function __invoke(string $email): void {
        $emailValidator = new EmailValidator();
        if($emailValidator->isEmailAndDnsValid($email)) {
            fwrite(STDOUT, "email is valid!");
        } else {
            fwrite(STDOUT, "email is not valid!");
        }

        fwrite(STDOUT, PHP_EOL);
    }
}