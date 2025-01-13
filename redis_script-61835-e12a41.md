# Redis

## Подготовка к занятию

```sh
docker run \
  --name otus-redis-7.2 \
  -v "$(pwd)/redis.conf":/etc/redis/redis.conf \
  -p 6379:6379 \
  -d \
  redis:7.2.5 redis-server /etc/redis/redis.conf
```

```sh
docker exec -it otus-redis-7.2 redis-cli
```

## Работа с данными

### Строки

```Redis
FLUSHDB
```

```Redis
SET user:1:name Dmitry
```

```Redis
GET user:1:name
```

```Redis
SET upload:counter 10
```

```Redis
INCR upload:counter
```

```Redis
SET cache:user:1 "json" EX 10
```

```Redis
TTL cache:user:1
```

```Redis
GET cache:user:1
```

```Redis
KEYS user*
```

```Redis
KEYS *
```

### Проверка знаний

```Redis
FLUSHDB
```

```Redis
SET user:1:name "Dmitry"
```

```Redis
GET user:1:name
```

```Redis
GET user:1
```

```Redis
SET user:1 "{name: Ivan}"
```

```Redis
GET user:1:name
```

### Хэш-таблицы

```Redis
FLUSHDB
```

```Redis
HSET user:1 name "Dmitry" age 43
```

```Redis
HGET user:1 name
```

```Redis
HGET user:1 age
```

```Redis
HSET user:1 name "Ivan"
```

```Redis
HINCRBY user:1 age 1
```

```Redis
HKEYS user:1
```

```Redis
HVALS user:1
```

```Redis
HDEL user:1 age
```

```Redis
HGETALL user:1
```

### Проверка знаний

```Redis
FLUSHDB
```

```Redis
HSET user:1 name "Dmitry" age 43
```

```Redis
HSET user:2 name "Ivan" age 20
```

```Redis
HGET user:1 name
```

```Redis
GET user:1
```

```Redis
HSET user:3 name "Olga" vozrast 35
```

### Списки

```Redis
FLUSHDB
```

```Redis
RPUSH user:1:posts post:10
```

```Redis
RPUSH user:1:posts post:11
```

```Redis
LPUSH user:1:posts post:12
```

```Redis
LRANGE user:1:posts 0 10
```

```Redis
RPOP user:1:posts
```

```Redis
LPOP user:1:posts
```

### Проверка знаний

```Redis
FLUSHDB
```

```Redis
RPUSH user:1:posts post:1
```

```Redis
RPUSH user:1:posts post:2
```

```Redis
RPUSH user:1:posts post:2
```

```Redis
RPUSH user:all:posts user:1:posts
```

```Redis
RPOP user:all:posts
```

```Redis
RPOP user:all:posts
```

### Множества

```Redis
FLUSHDB
```

```Redis
SADD users:online user:1
```

```Redis
SADD users:online user:2
```

```Redis
SADD users:online user:12
```

```Redis
SADD users:online user:12
```

```Redis
SCARD users:online
```

```Redis
SMEMBERS users:online
```

### Упорядоченные множества

```Redis
FLUSHDB
```

```Redis
ZADD users:rating 10 Ivan
```

```Redis
ZADD users:rating 5 Egor
```

```Redis
ZADD users:rating 15 Ira
```

```Redis
ZADD users:rating 15 Ira
```

```Redis
ZADD users:rating 7 Ira
```

```Redis
ZCARD users:rating
```

```Redis
ZCOUNT users:rating 5 10
```

```Redis
ZRANGE users:rating 5 10 BYSCORE
```

```Redis
ZRANK users:rating Ira
```

### Проверка знаний

```
С помощью чего можно реализовать…

1) Хранение сессий
2) Общие знакомые Стаса и Жени
3) 10 лучших постов Стаса
4) 10 последних постов Стаса…
5) …с датой, названием и тэгами

Варианты ответа:
Строки, Хэш-таблицы, Списки, Множества, Упорядоченные множества
```

## Транзакции

### Успешная транзакция

```Redis
FLUSHDB
```

```Redis
MULTI
```

```Redis
SET t1 "a"
```

```Redis
SET t2 10
```

```Redis
INCR t2
```

```Redis
EXEC
```

### Транзакция с откатом

```Redis
FLUSHDB
```

```Redis
MULTI
```

```Redis
SET t1 "a"
```

```Redis
SET t2 10
```

```Redis
INCR t2
```

```Redis
DISCARD
```

### Транзакция с синтаксической ошибкой

```Redis
FLUSHDB
```

```Redis
MULTI
```

```Redis
SET t1 "a"
```

```Redis
SETT t1
```

```Redis
SET t2 10
```

```Redis
EXEC
```

### Транзакция с логической ошибкой

```Redis
MULTI
```

```Redis
SET t1 "a"
```

```Redis
INCR t1
```

```Redis
SET t2 10
```

```Redis
EXEC
```

## Ссылка на опрос

```
https://otus.ru/polls/99089/
```