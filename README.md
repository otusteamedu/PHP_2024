# Система событий

## Запуск проекта

```shell
docker compose up -d
cp .env.example .env
docker exec -ti otus_app composer install
```

## Добавление таблицы

```shell
docker exec -ti otus_app php index.php migrate up
```

## Удаление таблицы

```shell
docker exec -ti otus_app php index.php migrate down
```

## Получить список всех пользователей

```shell
docker exec -ti otus_app php index.php get_users
```

## Получить пользователя по id

```shell
docker exec -ti otus_app php index.php get_user 1
```

## Добавить пользователя

```shell
docker exec -ti otus_app php index.php add_user --add="{'name':'test2','email':'test2@test.test'}"
```

## Очистка событий

```shell
docker exec -ti otus_app php index.php clear
```
