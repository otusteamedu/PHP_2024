# Деплой

1) Скопировать файл `.env.dist` как `.env`.
2) Заполнить поля в `.env` файле. Для примера можно взять данные ниже:

```dotenv
COMPOSE_PROJECT_NAME=homework8

###> postgres ###
POSTGRES_DB_HOST=postgres
POSTGRES_DB_NAME=homework
POSTGRES_PORT=5432
POSTGRES_USER=apps
POSTGRES_PASSWORD=apps
###< postgres ###
```

3) Ввести команды (вводить `docker-compose` или `docker compose` в зависимости от версии):

```bash
docker compose up -d --build
```

4) Данные по оптимизации БД находятся в файле `dump_optimized.sql`
