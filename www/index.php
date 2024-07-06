<?php

declare(strict_types=1);

echo '<h1>Hello world! ' . date('Y-m-d h:i:s') . '</h1>';

ini_set('display_errors', 'on');

require __DIR__ . '/vendor/autoload.php';

// check mysql
try {
    $dsn = 'mysql:host=' . getenv('MYSQL_HOST') . ';';
    $dsn .= 'dbname=' . getenv('MYSQL_DATABASE');

    $pdo = new PDO(
        $dsn,
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD')
    );
    echo 'Database connection: successful</br>';
} catch (\Throwable $e) {
    echo 'Database connection: error. ' . $e->getMessage() . '</br>';
}

$slugify = new SergeyProgram\OtusComposerPackageSlugify\SlugifyExtended();
$sentence = 'Текст для ссылки';

var_dump($slugify->slugify($sentence));
var_dump($slugify->slugifyCount($sentence));

echo '<br/>';

phpinfo();
