<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CustomDateTime</title>
</head>
<body>
<main class="main container">
    <h1>Библиотека для расширения возможностей \DateTime</h1>
    <section class="main__links links">
        <h2>Ссылки</h2>
        <p class="links__item">
            Github: <a href="https://github.com/pvSource/test-composer-package/">https://github.com/pvSource/test-composer-package/</a>
        </p>
        <p class="links__item">
            Packagist: <a href="#">#</a>
        </p>
    </section>
    <section class="main__example example">
        <h2>Пример работы:</h2>
        <?php include __DIR__ . '/example.php'?>
    </section>
</main>
<footer class="footer container">
    <p class="footer_description">
        Сделано в рамках курса Otus. PHP Professional. Автор: <a href="mailto:pavelsergmgtu@gmail.com">Павел Сергеевич</a>
    </p>
</footer>
</body>
</html>

<style>

    body {
        background: rgb(2,0,36);
        background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(121,92,9,1) 35%, rgba(0,212,255,1) 100%);
    }

    .container {
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .main {
        border: 1px black solid;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.59);
    }

    .main__links {
        border: 1px blue solid;
        background-color: rgba(100, 167, 255, 0.49);
        margin-bottom: 10px;
    }

    .main__links a {
        text-decoration: none !important;
        color: black;
        font-weight: bold;
    }

    .main__example {
        border: 1px #7a551d solid;
        background-color: rgba(255, 253, 125, 0.49);
    }

    .footer_description {
        text-align: right;
        font-style: italic;
        font-size: 12px;
        opacity: 0.8;
    }
</style>