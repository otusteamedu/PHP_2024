# HW1

## Настройка переменных окружения

Скопировать .env.example в новый файл .env и настроить переменные окружения в нем:

```bash
cp .env.example .env
```

## Сборка и запуск контейнеров

```bash
docker-compose up -d --build
```

## Установка зависимостей

```bash
docker-compose run --rm php-fpm composer install -d /var/www/html
```