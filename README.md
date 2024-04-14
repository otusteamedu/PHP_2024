# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Развертывание
### Сборка
```shell script
docker-compose build
```
### Запуск контейнеров
```shell script
docker-compose up -d &&
docker-compose exec php bash -c "export COMPOSER_HOME=/var/www/mm-service && composer install" &&
docker-compose exec php bin/console doctrine:migrations:migrate -n
```
### Остановка контейнеров
```shell script
docker-compose down
```

## Сценарии использования
### Создание новости
```shell script
curl --location 'http://localhost/api/v1/news/create' \
--header 'Content-Type: application/json' \
--data '{
    "url": "https://www.news.com/"
}'
```
### Получение списка новостей
```shell script
curl --location 'http://localhost/api/v1/news'
```
### Формирование отчета
```shell script
curl --location --globoff 'http://localhost/api/v1/news/report?ids[]=1&ids[]=2'
```
