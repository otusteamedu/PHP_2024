# Многофункциональный чат на сокетах

## Получить эхо от сервера
1. <любая строка>

## Проверить email
1. check:email {список в формате json}
   check:email {"check":[{"email":"john69683@gmail.com"},{"email":"john69683@gmail.xxx"}]}

## Redis
1. Добавить запись, где "event" - это тип записи:
   storage:post {"priority": 2000, "conditions": {"param1": 1, "param2": 2}, "event": {"type": 1}}

2. Получить запись по параметрам, , где "event" - это тип записи:
   storage:get {"event": {"param1": 1, "param2": 2}}

3. Удалить все записи типа, где "event" - это тип записи:
   storage:clear {"record":"event"}

## Elasticsearch
1. Создать индекс и установить настройки индекса из конфига:
   es:create {"index":"otus-shop"}

2. Получить информацию об индексе (без документов)
   es:info {"index":"otus-shop"}

3. Добавить (bulk) в индекс документы из файла, где otus-shop - название файла (без расширения!)
   (если ранее индекс не был создан будут установлены настройки индекса из конфига):
   es:bulk {"fileName":"otus-shop"} 

4. Добавить документ
   es:post {"index":"otus-shop","id":"999-999","body":{"title":"Молоко","sku":"999-999","price":1200}}

5. Получить документ
   es:get {"index":"otus-shop","id":"500-001"}
   es:get {"index":"otus-shop","id":"999-999"}

6. Удалить документ
   es:remove {"index":"otus-shop","id":"999-999"}

7. Поиск по условию
   es:search {"index":"otus-shop","body":{"query":{"range":{"price":{"gte":1200,"lt":1202}}}}}
   es:search {"index":"otus-shop","body":{"query":{"bool":{"must":[{"match":{"title":"красное"}}],"filter":[{"range":{"price":{"gte":9950}}}]}}}}
   es:search {"index":"otus-shop","body":{"query":{"match":{"title":{"query":"Вино белое Шардоне","fuzziness":"auto"}}}}}

8. Удалить индекс, где otus-shop - название индекса:
   es:clear {"index":"otus-shop"}   
