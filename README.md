# OTUS BOOK SHOP

```shell
docker exec -ti book_shop chmod +x app
```

# Для получения данных с сайта используется команда.

```shell
docker exec -ti book_shop php app app:spider
```

Более подробная информация

```shell
docker exec -ti book_shop php app app:spider --help
```

# Для индексирования данных в эластик команда.

```shell
docker exec -ti book_shop php app app:bulk
```

Более подробная информация

```shell
docker exec -ti book_shop php app app:bulk --help
```

# Для поиска используется команда.

```shell
docker exec -ti book_shop php app app:search
```

Команда поддерживает опции:

```shell
--title="Поиск по названию" # Поиск по части названия
--price=">100" --price="<=200" # Указание фильтра по ценам
--is_comment # Выводит книги только с комментариями
--page=1 # Для постраничного вывода. На одной странице выводится 100.
```

Более подробная информация 

```shell
docker exec -ti book_shop php app app:search --help
```

# Для более подробной информации по проекту.

```shell
docker exec -ti book_shop php app --help
```