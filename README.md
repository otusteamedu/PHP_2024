# Работа с rabbitmq

Запуск сервисов

```bash
docker-compose up -d
```

Запуск оболочки bash

```bash
docker compose exec app bash
```

Создание очередей

```bash
php console/create_queues.php
```

Запуск консюмера

```bash
php console/index.php
```

Отправка запроса

```bash
curl --location 'http://mysite.local' \
   --header 'Content-Type: application/json' \
   --data-raw '{"start_date":"02-06-2024", "end_date":"03-06-2024","email":"test2@mail.ru"}'
```
