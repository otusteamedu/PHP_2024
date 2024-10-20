# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Чат на сокетах

## Установка:

```sh
composer install
```

## Запуск сервера

```sh
docker exec -it app php app.php start-server
```

## Запуск клиента

```sh
docker exec -it app php app.php start-client
```

## Запуск тестов

```sh
docker exec -it app bash
```
```sh
XDEBUG_MODE=coverage vendor/bin/phpunit tests/ --coverage-text
```

## Результат выполнения тестов

```
PHPUnit 11.4.1 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.20 with Xdebug 3.3.2
Configuration: /var/www/html/phpunit.xml

...........WW....W..W                                             21 / 21 (100%)

Time: 00:00.176, Memory: 12.00 MB

OK, but there were issues!
Tests: 21, Assertions: 31, Warnings: 4.


Code Coverage Report:
  2024-10-20 21:58:21

 Summary:
  Classes: 20.00% (1/5)
  Methods: 50.00% (12/24)
  Lines:   73.47% (72/98)

Evgenyart\UnixSocketChat\App
  Methods:  40.00% ( 2/ 5)   Lines:  75.00% ( 15/ 20)
Evgenyart\UnixSocketChat\Client
  Methods:  25.00% ( 1/ 4)   Lines:  62.50% ( 10/ 16)
Evgenyart\UnixSocketChat\Config
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  8/  8)
Evgenyart\UnixSocketChat\Server
  Methods:  80.00% ( 4/ 5)   Lines:  73.33% ( 11/ 15)
Evgenyart\UnixSocketChat\Socket
  Methods:  44.44% ( 4/ 9)   Lines:  71.79% ( 28/ 39)

```