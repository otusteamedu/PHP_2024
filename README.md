# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Использование

1. В данной реализации типом записи может являтся любой тип, не только event
2. Поэтому для получения или удлаения записей нужно указать тип записи
3. Пример команд и данных:

```
1. Добавить запись, где "event" - это тип записи: 
storage:post {"priority": 2000, "conditions": {"param1": 1, "param2": 2}, "event": {"type": 1}}

2. Получить запись по параметрам, , где "event" - это тип записи: 
storage:get {"event": {"param1": 1, "param2": 2}}

3. Удалить все записи типа, , где "event" - это тип записи: 
storage:clear event

```