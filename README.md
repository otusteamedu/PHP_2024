# 1. Создать .env файл и задать там параметры
    RABBIT_USER=
    RABBIT_PASSWORD=
# 2. `docker-compose up -d`
# 3. `docker-compose run --rm php composer install`
# 4. Запустить слушателя
    `docker-compose run --rm php sh`
    `php console.php`
# 5. Отправить пост запрос на http://localhost:8080 с телом multipart-form
    message: 'string|required'
    email: 'email|required'
    