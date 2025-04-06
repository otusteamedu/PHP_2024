<?php

class GoogleCloudClient {
    private $apiKey;

    // Конструктор: инициализация API-ключа
    public function __construct() {
        // Убедитесь, что у вас есть API-ключ от Google Cloud
        $this->apiKey = 'AIzaSyCW0Zhk-93xfKWsDGqo5gfRfOv_cFWzltY'; // Замените на ваш API-ключ
    }

    // Метод для поиска видео
    // Метод для поиска видео
    public function searchVideos(string $keywords): array {
        $url = "https://www.googleapis.com/youtube/v3/search";
        $params = [
            'part' => 'snippet',
            'q' => urlencode($keywords),
            'type' => 'video',
            'maxResults' => 10,
            'order' => 'viewCount',
            'key' => $this->apiKey,
        ];

        $queryString = http_build_query($params);
        $fullUrl = $url . '?' . $queryString;

        $response = file_get_contents($fullUrl);
        if ($response === false) {
            throw new \Exception("Не удалось получить данные от Google Cloud API.");
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Ошибка при декодировании ответа: " . json_last_error_msg());
        }

        $videos = [];
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $videoId = $item['id']['videoId'];
                $title = $item['snippet']['title'];
                $url = "https://www.youtube.com/watch?v=$videoId";
                $thumbnail = $item['snippet']['thumbnails']['default']['url'] ?? null;

                $stats = $this->getVideoStatistics($videoId);

                $videos[] = [
                    'videoId' => $videoId,
                    'title' => $title,
                    'url' => $url,
                    'views' => $stats['views'] ?? 0,
                    'likes' => $stats['likes'] ?? 0,
                    'thumbnail' => $thumbnail,
                ];
            }
        }

        return $videos;
    }

    // Метод для получения статистики видео
    private function getVideoStatistics(string $videoId): array {
        $url = "https://www.googleapis.com/youtube/v3/videos";
        $params = [
            'part' => 'statistics',
            'id' => $videoId,
            'key' => $this->apiKey,
        ];

        // Формируем полный URL
        $queryString = http_build_query($params);
        $fullUrl = $url . '?' . $queryString;

        // Выполняем HTTP-запрос
        $response = file_get_contents($fullUrl);

        if ($response === false) {
            throw new \Exception("Не удалось получить статистику видео.");
        }

        // Декодируем JSON-ответ
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Ошибка при декодировании статистики: " . json_last_error_msg());
        }

        // Извлекаем данные
        $statistics = $data['items'][0]['statistics'] ?? [];
        return [
            'views' => $statistics['viewCount'] ?? 0,
            'likes' => $statistics['likeCount'] ?? 0,
        ];
    }
}