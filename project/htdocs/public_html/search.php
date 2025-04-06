<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/GoogleCloudClient.php';

// Проверяем, что форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем ключевые слова из формы
    $keywords = trim($_POST['keywords']);

    if (empty($keywords)) {
        echo "<p>Пожалуйста, введите ключевые слова.</p>";
        exit;
    }

    // Создаем экземпляр GoogleCloudClient
    $googleCloudClient = new GoogleCloudClient();

    try {
        // Выполняем поиск видео
        $videos = $googleCloudClient->searchVideos($keywords);

        // Выводим результаты
        echo "<h2>Результаты поиска для \"$keywords\":</h2>";
        if (!empty($videos)) {
            echo "<ul>";
            foreach ($videos as $video) {
                echo "<li>";
                echo "<strong>Название:</strong> " . htmlspecialchars($video['title']) . "<br>";
                echo "<strong>Ссылка:</strong> <a href='" . htmlspecialchars($video['url']) . "' target='_blank'>" . htmlspecialchars($video['url']) . "</a><br>";
                echo "<strong>Просмотры:</strong> " . htmlspecialchars($video['views']) . "<br>";
                echo "<strong>Лайки:</strong> " . htmlspecialchars($video['likes']) . "<br>";
                echo "</li>";
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
?>