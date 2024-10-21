<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Controller\Enum\ServiceCommand;

class CommandHandlerService
{
    public function commandHandler(string $clientMessage): string
    {
        $command = $clientMessage;
        $json = '';

        if (str_contains($clientMessage, ' ')) {
            $commandSeparatorIndex =  stripos($clientMessage, ' ');
            $command = substr($clientMessage, 0, $commandSeparatorIndex);
            $json = trim(substr($clientMessage, $commandSeparatorIndex));
        }

        return match (ServiceCommand::tryFrom($command)) {
            ServiceCommand::EmailValidate => (new EmailValidatorService())->validateEmail($json),

            ServiceCommand::StoragePost   => (new StorageService())->addRecord($json),
            ServiceCommand::StorageGet    => (new StorageService())->getRecord($json),
            ServiceCommand::StorageClear  => (new StorageService())->removeAllRecord($json),

            ServiceCommand::ElasticPost   => (new ElasticsearchService())->addRecord($json),
            ServiceCommand::ElasticGet    => (new ElasticsearchService())->getRecord($json),
            ServiceCommand::ElasticClear  => (new ElasticsearchService())->removeAllRecord($json),

            ServiceCommand::ElasticCreate => (new ElasticsearchService())->createIndex($json),
            ServiceCommand::ElasticInfo   => (new ElasticsearchService())->getIndexInfo($json),
            ServiceCommand::ElasticBulk   => (new ElasticsearchService())->bulk($json),
            ServiceCommand::ElasticRemove => (new ElasticsearchService())->removeRecord($json),
            ServiceCommand::ElasticSearch => (new ElasticsearchService())->search($json),

            default => ''
        };
    }
}
