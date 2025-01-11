# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

добавление события
````
php index.php -a '{ "priority": 1000, "conditions": { "param1": 1}, "event": "::event1::"}'
php index.php -a '{ "priority": 2000, "conditions": { "param1": 2, "param2":2}, "event": "::event2::"}'
php index.php -a '{ "priority": 3000, "conditions": { "param1": 1, "param2":2}, "event": "::event3::"}'
````
удаление событий
````
php index.php -c
````
получение события
````
php index.php -g '{"param1": 1,"param2":2}'
````