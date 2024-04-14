# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Пример использования
```
 // добавление нового события
 php index.php post '{ "priority": 100, "conditions": { "param124": 1 }, "event": { "name": "event", "description": "some event1"}}'
 // добавление еще одного события
 php index.php post '{ "priority": 1001, "conditions": { "param124": 1 }, "event": { "name": "event", "description": "some event1"}}'
 
 // получение события
 php index.php get '{ "param124": 1 }'
 
 // удаление всех событий
 php index.php delete
```