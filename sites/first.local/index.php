<?php require_once __DIR__ . '/preload.php';?>
<?php

use \Pananin\FirstLocal\Application\StringService;
use \Pavelsergeevich\DatetimePackage\CustomDateTime;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>first.local</title>
</head>
<body>
<header>
    <h1>Это первый сайт first.local</h1>
</header>
<main>
    <?php echo 'PHP работает'?>

    <section>
        <h2>Проверка работы Composer</h2>
        <?php $someString = 'Какая-то строка с разными символами, например: ?:*412::^__-опляJJread' ?>
        <?php $someStringSlugified = (new StringService($someString))->convert()->getString()?>
        <div>
            <p><strong>Строка до обработки:</strong><span><?=$someString?></span></p>
            <p><strong>Строка после обработки:</strong><span><?=$someStringSlugified?></span></p>
        </div>
    </section>

    <section>
        <h2>Проверка подключения своего пакета pavelsergeevich/datetime-package</h2>
        <?php

        $customDateTime = new CustomDateTime();
        $startWeek = $customDateTime->getStartWeek(CustomDateTime::FORMAT_MYSQL);

        echo "Понедельник текущий недели: $startWeek";
        ?>
    </section>

    <section>
        <?php
        $dbUser = 'root';
        $dbPass = 'root';
        $pdo = new PDO('mysql:host=mysql_hw1;dbname=hw1;charset=utf8', $dbUser, $dbPass);
        $obQuery = $pdo->query('SELECT * FROM otus_test');
        ?>
        <h2>Содержимое таблицы MySQL hw1 > otus_test</h2>
        <?php while ($arRow  = $obQuery->fetch()):?>
            <div style="border: 1px black solid">
                <p>ID = <?=$arRow['ID'] ?: '<i>null</i>'?></p>
                <p>NAME = <?=$arRow['NAME'] ?: '<i>null</i>'?></p>
                <p>DESCRIPTION = <?=$arRow['DESCRIPTION'] ?: '<i>null</i>'?></p>
                <p>IS_ACTIVE = <?=$arRow['IS_ACTIVE'] ? 'Да' : 'Нет' ?></p>
            </div>
        <?php endwhile;?>
    </section>
</main>
</body>
</html>
<style>
    section {
        border: 2px black solid;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>