# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Выбрал следующие паттерны:
* Строитель
* Абстрактная фабрика
* Шаблонный метод
* Итератор
* Прокси

## Задание

Разработайте несложную библиотеку для работы с базами данных. Вам потребуются несколько паттернов.

---

Строитель, Итератор: разработайте класс SelectQueryBuilder с методами:

- from(string $table)
- where(string $field, string $value)
- orderBy(string $field, string $direction)
- execute()

Требования к методам:

- класс должен запрашивать все поля из таблицы ( SELECT * )
- метод from() можно вызвать только один раз (при повторном вызове он перезапишет имя таблицы)
- метод where() можно вызвать несколько раз для разных полей
- метод orderBy() можно вызвать только один раз (при повторном вызове он перезапишет направление сортировки)
- метод execute() должен построить SQL-запрос, положить его в объект DatabaseQueryResult и вернуть этот объект

Требования к объекту DatabaseQueryResult: он должен реализовывать интерфейс Iterator (чтобы его можно было "перебрать" через foreach ).

Пример кода:

```php
$queryBuilder = new QueryBuilder();
$result = $queryBuilder
->from('products')
->where('type', 'Колбаса')
->where('price', 10000)
->orderBy('id', 'DESC')
->execute();

foreach ($result as $product) {
echo $product->title.PHP_EOL;
}
```
---

Прокси:

- по умолчанию при создании объекта DatabaseQueryResult сразу выполняется SQL-запрос
- нужно разработать класс DatabaseQueryResultProxy, который будет выглядеть аналогично DatabaseQueryResult, но при этом SQL-запрос будет выполняться только в момент первого запуска foreach (ленивые вычисления)

## Подготовка и запуск приложения
```
cd <project folder>
docker compose build .
docker run -v "./code:/data/mysite.local" -ti php_app /bin/bash -c "cd /data/mysite.local && composer install"
docker compose up
применить скрипт dump.sql к целевой БД
```

## Настройка приложения
Настройка приложения осуществляется посредством файла app.ini.