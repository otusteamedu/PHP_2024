# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Сборка
```shell
docker-compose build
```

## Запуск контейнеров
```shell
docker-compose up -d
```

## Остановка контейнеров
```shell
docker-compose down
```

## Команды
### Создание событий
```shell
docker exec -it php_2024-php-1 php ./src/app.php save '{"priority": 100, "condition": "rating = 10, type = 2", "payload": "{::event1::}"}'
```
```shell
docker exec -it php_2024-php-1 php ./src/app.php save '{"priority": 1000, "condition": "rating = 10, type = 2", "payload": "{::event2::}"}'
```
```shell
docker exec -it php_2024-php-1 php ./src/app.php save '{"priority": 10, "condition": "rating = 1000", "payload": "{::event3::}"}'
```
### Очистка хранилища событий
```shell
docker exec -it php_2024-php-1 php ./src/app.php clear
```
### Получение релевантного события в соответствии с заданными параметрами
```shell
docker exec -it php_2024-php-1 php ./src/app.php find '{"rating": 10, "type": 2}'
```
