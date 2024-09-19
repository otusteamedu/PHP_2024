<?php
// Получаем параметры подключения из переменных окружения
$host = getenv('POSTGRES_HOST');
$db = getenv('POSTGRES_DB');
$user = getenv('POSTGRES_USER');
$pass = getenv('POSTGRES_PASSWORD');
$port = getenv('POSTGRES_PORT');

$dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$pass";

try {
    // Подключаемся к базе данных
    $pdo = new PDO($dsn);

    // Устанавливаем режим обработки ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Выполняем запрос для получения списка таблиц
    $query = $pdo->query("
        SELECT table_name
        FROM information_schema.tables
        WHERE table_schema = 'public'
        ORDER BY table_name;
    ");

    $tables = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($tables) > 0) {
        echo "<h2>Список таблиц и количество записей в базе данных '$db':</h2>";
        echo "<ul>";
        foreach ($tables as $table) {
            $tableName = $table['table_name'];
            
            // Выполняем запрос для получения количества записей в таблице
            $countQuery = $pdo->query("SELECT COUNT(*) AS count FROM $tableName");
            $countResult = $countQuery->fetch(PDO::FETCH_ASSOC);
            $count = $countResult['count'];
            
            echo "<li>Таблица: $tableName - Записей: $count</li>";
        }
        echo "</ul>";
    } else {
        echo "В базе данных нет таблиц.";
    }
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
