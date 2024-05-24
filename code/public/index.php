<?php
declare(strict_types=1);

require_once dirname(dirname(__DIR__)).'/vendor/autoload.php';

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

// возвращает путь запроса
// вырезает index.php из пути
function getRequestPath(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo "opened";
    return '/' . ltrim(str_replace('index.php', '', $path), '/');

}

//echo getRequestPath();

$news_url = 'https://lenta.ru/news/2024/05/24/byvshiy-zavod-nissan-v-rossii-otpravil-sotrudnikov-v-prostoy/';


$meta = get_meta_tags($news_url);

echo $meta['title'];

