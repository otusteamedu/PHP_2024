# OTUS BOOK SHOP

```shell
docker exec -ti book_shop chmod +x app
```

# Подключение elasticsearch

После запуска проекта, запустите команду, для генерации пароля:

```shell
docker exec -ti elastic_book bin/elasticsearch-reset-password -u elastic
```

В консоль выведется пароль необходимый для работы.
Сохраните его в переменную `ELASTICSEARCH_PASSWORD` в `.env`.

Необязательно. Копируем себе сертификат и указываем до него путь в `ELASTICSEARCH_CA_BUNDLE` в `.env`.

```shell
docker cp elastic_book:/usr/share/elasticsearch/config/certs/http_ca.crt ./config/http_ca.crt
```

Устанавливаем зависимоти.

```shell
docker exec -ti book_shop composer install --optimize-autoloader
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
--index="otus-book" # Можно указать индекс
--page=1 # Для постраничного вывода. На одной странице выводится 100.
- Точное значение: field=value
- Диапазон: field[operator]=value (операторы: eq, gt, gte, lt, lte)
- Множественные значения: field[]=value1&field[]=value2
- Поиск по подстроке: field~=value
Примеры: 
- -f "title=PHP"
- -f "price[gte]=100" -f "price[lte]=200"
- -f "genre[]=fiction" -f "genre[]=programming"
- -f "description~=best"
```

```shell
docker exec -ti book_shop php app app:search -f "title~=империя" -f "price[gt]=500" -f "price[lte]=2000"
```

Более подробная информация 

```shell
docker exec -ti book_shop php app app:search --help
```

# Для более подробной информации по проекту.

```shell
docker exec -ti book_shop php app --help
```
