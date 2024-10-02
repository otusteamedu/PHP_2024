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

        if (str_contains($clientMessage, ServiceCommand::StoragePost->value)) {
            $string = trim(substr($clientMessage, strlen(ServiceCommand::StoragePost->value)));

            return (new StorageService())->addRecord($string);
        }

        if (str_contains($clientMessage, ServiceCommand::StorageGet->value)) {
            $string = trim(substr($clientMessage, strlen(ServiceCommand::StorageGet->value)));

            return (new StorageService())->getRecord($string);
        }

        if (str_contains($clientMessage, ServiceCommand::StorageClear->value)) {
            $string = trim(substr($clientMessage, strlen(ServiceCommand::StorageClear->value)));

            return (new StorageService())->removeAllRecord($string);
        }

        return '';
    }
}
