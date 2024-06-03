<?php

/**
 * @var string $email
 * @var string $text
 * @var array $errors
 * @var string $infoMessage
 */

?>
<html lang="ru">
    <head>
        <title>Обработка сообщений</title>
        <style>
            .inputBlock {
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <?php if (!empty($infoMessage)) :?>
            <h3 style="color: green">
                <?=$infoMessage?>
            </h3>
            <hr>
        <?php endif; ?>

        <?php if (count($errors) > 0) : ?>
            <?php foreach ($errors as $errorMessages) : ?>
                <?php $errorMessage = $errorMessages[0]; ?>
                <h3 style="color: red;">
                    <?=$errorMessage?>
                </h3>
            <?php endforeach; ?>
            <hr>
        <?php endif; ?>

        <form action='/' method="post" name="messageForm">
            <div class="inputBlock">
                <label for="email">Email</label><br>
                <input id="email" name="email" type="text" size="50" value="<?=$email?>">
            </div>

            <div class="inputBlock">
                <label for="message">Сообщение</label><br>
                <textarea id="message" name="text" cols="50" rows="5"><?=$text?></textarea>
            </div>

            <div class="inputBlock">
                <input type="submit" value="Отправить">
            </div>
        </form>
    </body>
</html>
