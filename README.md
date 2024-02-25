# Библиотека для верификации email

Проверяет на соответствие шаблону email и на наличие mx-записи.

## Требования

- PHP >=7.0

## Установка

```bash
composer require pozys/email-validator
```

## Использование

```php
$validator = new Validator();
$emails = [
    'jvL4r@gmail.com',
    'jvL4rexample.com',
    'jvL4r@examplesdsdsdf.fr',
];
var_export($validator->verify($emails));
// [
//     'jvL4r@gmail.com' => true,
//     'jvL4rexample.com' => false,
//     'jvL4r@examplesdsdsdf.fr' => false
// ]
```
