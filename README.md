# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## CI/CD:

1. За основу взята код с домашней работы "18 - Чат на сокетах"
2. Был арендован VPS, на нем установлен gitlab-runner, docker, docker compose, php-codesniffer
3. Создан проект в gitlab https://skrinshoter.ru/sSpLBxpoVnj
4. Создан runner и связан с установленным runner-ом на VPS: https://skrinshoter.ru/sSpI45UGfGj
5. В файле .gitlab-ci.yml описано 4 стадии:
	а) analysis - простая проверка кода codesniffer'ом. Лог Job-ы в случае успеха https://skrinshoter.ru/sSpw9vpGa9J
	б) build - сборка образа, установка зависимостей через композер. Лог Job-ы в случае успеха https://skrinshoter.ru/sSpT4x58ksX
	в) test - запуск Unit тестов, которые были написаны в рамках 18й домашней работы. Лог Job-ы в случае успеха https://skrinshoter.ru/sSpzHPd102s
	г) deploy - если обновилась ветка main, то перейти в каталог проект, сделать git pull, пересобрать контейнеры и установить зависимости через композер. 
	лог Job-ы в случае успеха: https://skrinshoter.ru/sSpFZiDdela


-------

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