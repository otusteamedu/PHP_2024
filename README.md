# PHP_2024

## Инструкция для запуска:

1. Создать .env файл и задать там параметры
```
    MYSQL_HOST=mysql-31
    MYSQL_ROOT_PASSWORD=root
    MYSQL_DATABASE=hw31
    MYSQL_USER=user
    MYSQL_PASSWORD=root
    MYSQL_PORT=3306
    
    RABBIT_HOST=rabbit-31
    RABBIT_USER=user
    RABBIT_PASSWORD=root
    RABBIT_UI_PORT=15672
    RABBIT_PORT=5672
```

2. `composer install`
3. `docker-compose up -d`

4. Создать пользовательскую задачу
```
Отправить POST запрос на http://mysite.local:8080/customer-task с телом JSON
{
    "name": "task1",
    "description": "task1 description"
}
В ответе должен прийти id новой задачи:
{
    "statusCode": 200,
    "data": "11"
}
```

5. Отправить GET запрос на http://mysite.local:8080/customer-task/${id} чтобы узнать статус задачи
