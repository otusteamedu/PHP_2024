<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusElasticsearchApp;

use SlavaMakhov\OtusElasticsearchApp\Services\ElasticSearchService;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;

class App
{
    /**
     * Старт приложения
     *
     * @return string
     *
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     * @throws Exception
     */
    public function run(): string
    {
        $args = $_SERVER['argv'];
        $this->checkArgsData($args);
        $command = $args[1];
        $elasticSearch = new ElasticSearchService();

        return match ($command) {
            'create-index' => $elasticSearch->createIndex() . PHP_EOL,
            'delete-index' => $elasticSearch->deleteIndex() . PHP_EOL,
            'bulk' => $elasticSearch->bulkDocumentCreate($args[2]) . PHP_EOL,
            'search' => $elasticSearch->search($args[2]) . PHP_EOL,
            'get-doc' => $elasticSearch->getDocumentById($args[2]) . PHP_EOL,
            'update-doc' => $elasticSearch->updateDocumentById($args[2], $args[3]) . PHP_EOL,
            'delete-doc' => $elasticSearch->deleteDocumentById($args[2]) . PHP_EOL,

            default => throw new Exception('Команда ' . $command . ' не существует!' . PHP_EOL)
        };
    }

    /**
     * Метод проверяет введенные параметры
     * пользователем в консоли
     *
     * @throws Exception
     */
    private function checkArgsData(array $args): void
    {
        if (!isset($args[1])) {
            throw new Exception("Для дальнейшей работы, необходимо передать команду!" . PHP_EOL);
        }
        $command = $args[1];

        if ($command == 'get-doc' || $command == 'delete-doc' || $command == 'search' || $command == 'bulk') {
            if (!isset($args[2])) {
                throw new Exception("Для дальнейшей работы, необходимо передать второй аргумент!" . PHP_EOL);
            }
        }

        if ($command == 'update-doc' && !isset($args[2]) && !isset($args[3])) {
            throw new Exception("Для дальнейшей работы, необходимо передать второй и третий аргумент!" . PHP_EOL);
        }
    }
}