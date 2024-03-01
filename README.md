# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## HW7
### Диаграмма
Диаграмма в формате vpp (делал в Visual Paradigm) и формате png скриншота содержится в директории /diagram
![Диаграмма](/diagram/hw7.png "Диаграмма")

### Создание и заполнение БД
SQL код проверялся и является валидным для PostgreSQL 16.<br>
Для создания таблиц и их заполнения выполнить по порядку:<br>
_Я не понял как (по крайней мере в DataGrip) сделать переход в базу данных по аналогии с MySQL (USE hw7;) [про \c hw7 в курсе, но DataGrip отказывается это понимать] после создания таблицы, поэтому тут нужно самому туда перейти по своему усмотрению как, после выполнения кода из первого файла:)_
```
create/1_create_database.sql
create/2_create_tables.sql 
insert/3_insert_test_data.sql 
```

### Выборки

```
select/top_profit_film.sql      # Самый продаваемый фильм (в денежном измерении)
select/top_3_profit_genres.sql  # Топ-3 продаваемых (в денежном измерении) жанра
select/top_5_buyers.sql         # Топ-5 покупателей (в денежном измерении)
select/no_ticket_films.sql      # Все фильмы на которые не было куплено ни одного билета
```
