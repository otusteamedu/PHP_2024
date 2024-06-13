# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Инструкция для запуска:

1. Создать .env файл и задать там параметры
```
   RABBIT_MQ_HOST=
   RABBIT_MQ_PORT=
   RABBIT_MQ_UI_PORT=
   RABBIT_MQ_USER=
   RABBIT_MQ_PASSWORD=
```
2. `composer install`
3. `docker-compose up -d`
4. Перейти в телеграм-чат с ботом `https://t.me/+kcTccW8du09lNTFi`
5. Отправить POST запрос на http://localhost:80
   `{
   "data": "data"
   }`
