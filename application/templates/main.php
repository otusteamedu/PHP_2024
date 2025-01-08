<?php
/**
 * @var  $value
 * @var  $success
 * @var  $hostname
 * @var  $result
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Запрос обработал контейнер: <?=$hostname?></p>
    <h1>Валидатор строки со скобками</h1>
    <form action="/" method="POST">
        <input size="50" type="text" name="string" placeholder="Введите строку со скобками пример(Привет(как(дела)))"
               value="<?=$value?>">
        <button type="submit">Валидировать</button>
    </form>
    <?php if (!$success) { ?>
        <div style="color: red">
            <?=$result?> <a href="/">Попробуйте еще раз</a>
        </div>
    <?php } else { ?>
        <div style="color: green">
            <?=$result?>
        </div>
    <?php } ?>
</body>
</html>
