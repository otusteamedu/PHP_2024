# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Инструкция

1. .env.example -> .env
2. установить значения POSTGRES_PASSWORD и RABBIT_PASSWORD
3. app/.env.example -> app/.env
4. установить значения DATABASE_URL (подключение к базе данных) и MESSENGER_TRANSPORT_DSN (подключение к rebbutMQ)
Например
`DATABASE_URL="postgresql://postgres:password_postgres@db:5432/hw21?serverVersion=15&charset=utf8"`
`MESSENGER_TRANSPORT_DSN=amqp://rabbithw21:password_rabbit@rabbitmq:5672/%2f`
5. `docker-compose up -d --build` 
6. Установить пакеты командй
`docker exec -it app composer install`
7. Выполнить миграцию
`docker exec -it app bin/console doctrine:migrations:migrate`
8. Запустить Comsumer командой:
`php bin/console messenger:consume async`
9. Отправить POST запрос с заявкой на новую выписку:
`curl --location 'http://localhost/api/v1/statement' \
--header 'Content-Type: application/json' \
--data '{
    "account": "123",
    "dateFrom": "2024-01-01",
    "dateTo": "2024-01-31"
}'`
10. Ответ в случае успеха с кодом 201:
`{"id":108}`
11. Для проверки статуса запроса отправить GET запрос:
`curl --location 'http://localhost/api/v1/statement/100'`
12. Ответ в случае успеха:
`{"id":100,"account":"123","date_from":"2024-01-01","date_to":"2024-01-31","status":"new","date_created":"2024-11-19
16:19:08"}`
13. По адресу /api/doc доступено описение API, сгенерированное с помощью NelmioApiDocBundle
14. Скины описания API:
- https://skrinshoter.ru/sSmEEKr15Tc
- https://skrinshoter.ru/sSmBQb2kqi3
