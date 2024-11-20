# PHP_2024

## Инструкция для запуска:

1. Создать .env файл и задать там параметры
```
    RABBIT_USER=
    RABBIT_PASSWORD=
    RABBIT_PORT=
    RABBIT_UI_PORT=
    RABBIT_HOST=
```

2. `composer install`
3. `docker-compose up -d`

4. Запустить слушателя. Для этого необходимо перейти в docker в контейнер `app-hw30` -> terminal и выполнить в консоли
```
cd mysite.local
cd public
php index.php consumer
```

5. Отправить пост запрос на http://localhost:8080 с телом multipart-form

    name: 'string|required'
    email: 'email|required'
