<?php

declare(strict_types=1);


namespace Main\Infrastructure;


interface ElasticsearchServiceInterface
{

    /**
     * Создает индекс Elasticsearch с заданными настройками и маппингами.
     *
     * @param string $indexName Название индекса.
     * @param array $body body.
     * @return bool Результат операции (успешно или нет).
     */
    public function createIndex(string $indexName, array $body): bool;

    /**
     * Удаляет индекс Elasticsearch.
     *
     * @param string $indexName Название индекса.
     * @return bool Результат операции (успешно или нет).
     */
    public function deleteIndex(string $indexName): bool;

    /**
     * Выполняет поиск по индексу Elasticsearch с заданным запросом.
     *
     * @param array $queryParams Запрос для выполнения поиска.
     * @return array Результаты поиска в виде массива данных.
     */
    public function search(array $queryParams): array;

    /**
     * Клиент elastick search
     * @return Elastic\Elasticsearch\ClientBuilder
     */
    public function getClient() :Elastic\Elasticsearch\ClientBuilder;



}