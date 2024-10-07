# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

Команды для теста функционала:

## Получить все записи

```sh
docker exec -it app php app.php selectall
```

## Получить одну запись по id

```sh
docker exec -it app php app.php select 1
```

## Добавить новую запись

```sh
docker exec -it app php app.php insert Mask Mask 1998-01-01 5 102 "Cool film"
```

## Удалить запись по id

```sh
docker exec -it app php app.php delete 9
```

## Обновить запись по id

```sh
docker exec -it app php app.php update 2 duration 102
```