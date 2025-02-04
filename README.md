# Система событий

## Запуск проекта

```shell
docker compose up -d
cp .env.example .env
docker exec -ti otus_storage composer install
```

## Добавление событий

```shell
docker exec -ti otus_storage php index.php add --priority=1000 --conditions='{"param1":1}' --event='
{"type":"event1"}'
```

```shell
docker exec -ti otus_storage php index.php add --priority=2000 --conditions='{"param1":1,"param2":2}' --event='
{"type":"event2"}'
```

```shell
docker exec -ti otus_storage php index.php add --priority=3000 --conditions='{"param1":1,"param2":2}' --event='
{"type":"event3"}'
```

## Поиск событий

```shell
docker exec -ti otus_storage php index.php find --params='{"param1":1,"param2":2}'
```

## Очистка событий

```shell
docker exec -ti otus_storage php index.php clear
```
