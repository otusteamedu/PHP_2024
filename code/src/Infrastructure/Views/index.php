<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js"
            type="text/javascript"></script>
    <script>

        jQuery(document).ready(function ($) {
            $('label').click(function () {
                var id_label = $(this).attr('for');
                $('[name="' + id_label + '"]').trigger('focus');
            });
            $('[name="phone"]').mask("+7(999)999-99-99");
            $('[name="date1"]').mask('99.99.9999');
            $('[name="date2"]').mask('99.99.9999');
        });
    </script>
</head>

<body>
<div class="contain">
    <form id="add-request" class="form-gs contain__form-gs" method="post">
        <input type="hidden" name="form-id" value="form-contact">
        <div class="title-form">Запрос банковской выписки за указанные даты:</div>
        <div class="form-gs__item">
            <label for="email" class="label-form">Email: </label><input type="text" class="input-form" name="email"
                                                                        value="<?php echo $email;?>">
        </div>
        <div class="form-gs__item">
            <label for="phone" class="label-form">Телефон: </label><input type="text" class="input-form" name="phone"
                                                                          value="<?php echo $phone;?>">
        </div>
        <div class="form-gs__item">
            <label for="firstname" class="label-form">Имя: </label><input type="text" class="input-form"
                                                                          name="firstname" value="<?php echo $firstname;?>">
        </div>
        <div class="form-gs__item">
            <label for="firstname" class="label-form">Банковская выписка (диапазон дат):</label>
        </div>
        <div class="form-gs__item">
            <label for="firstname" class="label-form">От: </label><input type="text" class="input-form"
                                                                         name="date1" value="<?php echo $date1;?>">
        </div>
        <div class="form-gs__item">
            <label for="firstname" class="label-form">до: </label><input type="text" class="input-form"
                                                                         name="date2" value="<?php echo $date2;?>">

        </div>
        <div class="form-gs__item">
            <button id = "submit"  type = "submit" class="but-send">Отправить</button>
        </div>
    </form>
    <br>
    <div id="result-form" ><?php echo $resError;?></div>
</div>

</body>

</html>