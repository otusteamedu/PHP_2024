<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\ServiceCommand;

class CommandHandlerService
{
    /**
     * @param string $clientMessage
     * @return string
     */
    public function commandHandler(string $clientMessage): string
    {
        if (str_contains($clientMessage, ServiceCommand::EmailValidate->value)) {
            $emailList = substr($clientMessage, strlen(ServiceCommand::EmailValidate->value));

            return (new EmailValidatorService())->validateEmail($emailList, false);
        }

        return '';
    }
}
