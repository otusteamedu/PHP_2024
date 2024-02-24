<!doctype html>
<html lang="ru">
<head>
    <title><?= $this->title ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <header class="header">
        <div class="header__container container">
            <h1><?= $this->title ?></h1>
        </div>
    </header>
    <main class="main">
        <div class="main__container container">
            <?php echo $this->pageContent ?>
        </div>
    </main>
    <footer class="footer">
        <div class="footer__container container">
            Отладочная информация:<br>
            Запрос обработал контейнер: <?= getenv('HOSTNAME') ?><br>
        </div>
    </footer>
</body>
</html>