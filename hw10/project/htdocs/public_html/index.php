<?php
// Подключаем автозагрузку Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Подключаем класс Manager
require_once __DIR__ . '/../src/Manager.php';

// Создаем экземпляр класса Manager
$manager = new Manager();

// Определяем маршрут из параметра запроса
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        // Главная страница
        $manager->displayWelcomeForm();
        break;

    case 'search-form':
        // Форма поиска
        $manager->displaySearchForm();
        break;

    case 'search':
        // Обработка поиска видео
        $manager->handleSearch();
        break;

    default:
        echo "<p>Страница не найдена.</p>";
        break;
}