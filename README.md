# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Example

```php
$mailService = new MailService();

if ($mailService->validate(['ivarthewebdeveloper@gmail.com', 'nisaga.2002.11.04@gmail.com'])) {
    echo 'Email is valid';
} else {
    echo 'Email is not valid';
}
```