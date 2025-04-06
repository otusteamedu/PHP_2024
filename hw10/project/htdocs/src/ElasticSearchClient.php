<?php

use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchClient {
    private $client;
    private $indexName = 'videos'; // Имя индекса для хранения данных

    // Конструктор: инициализация клиента Elasticsearch
    public function __construct() {
        try {
            $this->client = ClientBuilder::create()
                ->setHosts(['http://host.docker.internal:9200']) // Имя сервиса Docker
                ->build();

            // Создаем индекс, если он не существует
            if (!$this->client->indices()->exists(['index' => $this->indexName])) {
                $this->client->indices()->create(['index' => $this->indexName]);
            }
        } catch (\Exception $e) {
            die("Ошибка подключения к Elasticsearch: " . $e->getMessage());
        }
    }
    public function saveVideo(array $video) {
        try {
            if (empty($video['videoId']) || !is_string($video['videoId'])) {
                throw new \Exception("Неверный videoId: " . json_encode($video));
            }

            $document = [
                'title' => $video['title'] ?? null,
                'url' => $video['url'] ?? null,
                'views' => $video['views'] ?? 0,
                'likes' => $video['likes'] ?? 0,
                'thumbnail' => $video['thumbnail'] ?? null,
                'timestamp' => date('Y-m-d H:i:s'),
            ];

            $params = [
                'index' => $this->indexName,
                'id' => $video['videoId'],
                'body' => $document,
            ];
            error_log("Saving video: " . json_encode($params));

            $response = $this->client->index($params);
            error_log("Save response: " . json_encode($response));
        } catch (\Exception $e) {
            error_log("Ошибка при сохранении видео в Elasticsearch: " . $e->getMessage() . " | Stack trace: " . $e->getTraceAsString());
        }
    }


    public function getSavedVideos(): array {
        try {
            $params = [
                'index' => $this->indexName
            ];
            error_log("Search params: " . json_encode($params));

            $response = $this->client->search($params);
            error_log("Search response: " . json_encode($response));

            $videos = [];
            if (isset($response['hits']['hits'])) {
                foreach ($response['hits']['hits'] as $hit) {
                    $videos[] = $hit['_source'];
                }
            }

            return $videos;
        } catch (\Exception $e) {
            error_log("Ошибка при получении видео из Elasticsearch: " . $e->getMessage() . " | Stack trace: " . $e->getTraceAsString());
            return [];
        }
    }
}