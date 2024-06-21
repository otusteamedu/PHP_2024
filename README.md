# Design Patterns

Разработайте небольшую библиотеку для работы с базами данных. Вам потребуются несколько паттернов.

---

Строитель: разработайте класс SelectQueryBuilder с методами:

- from(string $table): self
- where(string $field, string $value): self
- orderBy(string $field, string $direction): self
- execute(): DatabaseQueryResult

Требования к методам:

- класс должен запрашивать все поля из таблицы ( SELECT * ... )
- метод from() можно вызвать только один раз (при повторном вызове он перезапишет имя таблицы)
- метод where() можно вызвать несколько раз для разных полей
- метод orderBy() можно вызвать только один раз (при повторном вызове он перезапишет направление сортировки)
- метод execute() должен построить и выполнить SQL-запрос, после чего положить результат в объект DatabaseQueryResult и вернуть этот объект

Требования к объекту DatabaseQueryResult: он должен реализовывать интерфейс Iterator (чтобы его можно было "перебрать" через foreach).

Пример кода:

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

---

Прокси:

- по умолчанию при создании объекта DatabaseQueryResult сразу выполняется SQL-запрос
- нужно разработать класс DatabaseQueryResultProxy, который будет совпадать с DatabaseQueryResult в плане интерфейса, но при этом SQL-запрос будет выполняться только в момент первого запуска foreach (ленивые вычисления)

---

Наблюдатель: добавьте 2 события жизненного цикла:

- DatabaseQueryResultIsCreated (после создания объекта DatabaseQueryResult)
- SqlIsExecuted (после реального выполнения SQL-запроса)

Разработайте код подписки на эти события.
