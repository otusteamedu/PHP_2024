# PHP_2024

## Валидация E-mail

### Рекомендуемый порядок работы

1. Вставить email адреса для проверки в файл "/code/src/emails.txt". Каждый email с новой строки.
2. Установить контейнер php:

```
docker-compose up -d
```

3. Установить приложение:

```
docker exec -it php composer install
```

4. Запустить проверку email:

```
docker exec -it php php app.php
```

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus
