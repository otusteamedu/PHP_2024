# Процессор строк

HW1-3 composer package

Библиотека даёт беспрецедентную возможность обратиться  к **Magic Ball'у** с любым вопросом.
Но учти, дружочек, **Magic Ball** ответит тебе только *"Да"* или *"Нет"*. Внемли гласу ___Макоши!___:smiling_imp:


## Трбования

- PHP  5.6

## Установка

`
composer require slipka007/hw1-3-composer-package
`

## Использование

```php
<?php

$answer = new MagicBall();
echo $answer->getAnswer();?>