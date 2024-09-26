# Материалы к занятиям

- "PostgreSQL для администратора"
- "PostgreSQL для разработчика"

Содержит compose файл с сервисом postgresql от официального источника.

Для запуска необходим Docker и docker-compose.

Порядок запуска: 

1. `docker-compose up -d`
2. `docker-compose exec db bash`
3. `psql -U postgres`

Каталог `/dump` содержит пример простого скрипта создания таблицы и засеивания первоначальными данными.

Каталог `/data` - это volume на служебный каталог postgresql.

Каталог `/content` - основное содержимое для занятий.