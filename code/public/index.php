<?php
declare(strict_types=1);

$db = null;

try {
    $db = pg_connect(
        "host=postgres dbname=".
        getenv("POSTGRES_DATABASE").
        " user=".getenv("POSTGRES_USER").
        " password=".getenv("POSTGRES_PASSWORD")
    );
} catch (Exception $exception) {
    echo $exception->getMessage();
}



//pg_query($db,"INSERT INTO news (date, url, title) VALUES (CURRENT_DATE,'http://test.local/news/1','News 1');");
//
//var_dump(pg_fetch_all(pg_query($db,"SELECT * FROM news;")));

// Маршруты
// [маршрут => функция которая будет вызвана]
$routes = [
    // срабатывает при вызове корня или /index.php
    '/' => 'hello',
    // срабатывает при вызове /about или /index.php/about
    '/about' => 'about',
    // динамические страницы
    '/page' => 'page'
];

// возвращает путь запроса
// вырезает index.php из пути
function getRequestPath(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo "opened";
    return '/' . ltrim(str_replace('index.php', '', $path), '/');

}

echo getRequestPath();