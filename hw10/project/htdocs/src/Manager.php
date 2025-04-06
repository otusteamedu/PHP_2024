<?php

require_once __DIR__ . '/ElasticSearchClient.php';
require_once __DIR__ . '/GoogleCloudClient.php';

class Manager {
    private $elasticSearchClient;
    private $googleCloudClient;

    // Конструктор: инициализация клиентов
    public function __construct() {
        $this->elasticSearchClient = new ElasticSearchClient();
        $this->googleCloudClient = new GoogleCloudClient();
    }

    // Метод для вывода главной страницы
    public function displayWelcomeForm() {
        $savedVideos = $this->elasticSearchClient->getSavedVideos();

        $htmlFilePath = __DIR__ . '/../public_html/view/index.html';
        if (file_exists($htmlFilePath)) {
            $htmlContent = file_get_contents($htmlFilePath);

            $savedVideosHtml = '';
            if (!empty($savedVideos)) {
                $savedVideosHtml .= "<h2>Сохраненные видео:</h2><ul>";
                foreach ($savedVideos as $video) {
                    $savedVideosHtml .= "<li>";
                    $savedVideosHtml .= "<strong>Название:</strong> " . htmlspecialchars($video['title']) . "<br>";
                    $savedVideosHtml .= "<strong>Ссылка:</strong> <a href='" . htmlspecialchars($video['url']) . "' target='_blank'>" . htmlspecialchars($video['url']) . "</a><br>";
                    $savedVideosHtml .= "<strong>Просмотры:</strong> " . htmlspecialchars($video['views']) . "<br>";
                    $savedVideosHtml .= "<strong>Лайки:</strong> " . htmlspecialchars($video['likes']) . "<br>";
                    if (!empty($video['thumbnail'])) {
                        $savedVideosHtml .= "<img src='" . htmlspecialchars($video['thumbnail']) . "' alt='Thumbnail' style='max-width: 100px;'><br>";
                    }
                    $savedVideosHtml .= "</li>";
                }
                $savedVideosHtml .= "</ul>";
            } else {
                $savedVideosHtml = "<p>Нет сохраненных видео.</p>";
            }

            $htmlContent = str_replace('{{saved_videos}}', $savedVideosHtml, $htmlContent);
            echo $htmlContent;
        } else {
            echo "Ошибка: Файл с формой не найден.";
        }
    }

    // Метод для вывода формы поиска
    public function displaySearchForm() {
        $htmlFilePath = __DIR__ . '/../public_html/view/search.html';

        if (file_exists($htmlFilePath)) {
            $htmlContent = file_get_contents($htmlFilePath);
            echo $htmlContent;
        } else {
            echo "Ошибка: Файл с формой поиска не найден.";
        }
    }

    // Метод для обработки поиска видео
    public function handleSearch() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $keywords = trim($_POST['keywords']);

            if (empty($keywords)) {
                echo "<p>Пожалуйста, введите ключевые слова.</p>";
                exit;
            }

            try {
                $videos = $this->googleCloudClient->searchVideos($keywords);

                echo "<h2>Результаты поиска для \"$keywords\":</h2>";
                if (!empty($videos)) {
                    echo "<ul>";
                    foreach ($videos as $video) {
                        echo "<li>";
                        echo "<strong>Название:</strong> " . htmlspecialchars($video['title']) . "<br>";
                        echo "<strong>Ссылка:</strong> <a href='" . htmlspecialchars($video['url']) . "' target='_blank'>" . htmlspecialchars($video['url']) . "</a><br>";
                        echo "<strong>Просмотры:</strong> " . htmlspecialchars($video['views']) . "<br>";
                        echo "<strong>Лайки:</strong> " . htmlspecialchars($video['likes']) . "<br>";
                        if (!empty($video['thumbnail'])) {
                            echo "<img src='" . htmlspecialchars($video['thumbnail']) . "' alt='Thumbnail' style='max-width: 100px;'><br>";
                        }
                        echo "</li>";

                        $this->elasticSearchClient->saveVideo($video);
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Видео не найдены.</p>";
                }
            } catch (\Exception $e) {
                echo "<p>Ошибка при выполнении запроса: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } else {
            echo "<p>Неверный запрос.</p>";
        }
    }
}