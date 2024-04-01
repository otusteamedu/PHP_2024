Разработайте несложную библиотеку для работы с базами данных. Вам потребуются несколько паттернов.

---

Строитель: разработайте класс SelectQueryBuilder с методами:

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

```
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