# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

Команды:

## Добавить события

```sh
docker exec -it app php app.php add '{"priority": 1000, "conditions": {"param1": 1, "param2": 2}, "event": "event_1"}'
```
```sh
docker exec -it app php app.php add '{"priority": 2000, "conditions": {"param1": 2, "param2": 2}, "event": "event_2"}'
```
```sh
docker exec -it app php app.php add '{"priority": 3000, "conditions": {"param1": 1, "param2": 2}, "event": "event_3"}'
```
```sh
docker exec -it app php app.php add '{"priority": 4000, "conditions": {"param1": 3, "param2": 2}, "event": "event_4"}'
```
```sh
docker exec -it app php app.php add '{"priority": 5000, "conditions": {"param1": 1}, "event": "event_5"}'
```

## Получить событие по фильтру

```sh
docker exec -it app php app.php get '{"params": {"param1": 1, "param2" : 2}}'
```

## Очистить все события

```sh
docker exec -it app php app.php clear
