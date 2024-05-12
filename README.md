# PHP_2024

Проверка системы осуществляется через прямые команды к контейнеру fpm с параметрами.

Примечание: 
1. Первый аргумент запроса - одна из команд (указаны ниже).
2. Второй, третий и четвертый аргументы - рейтинг, условия и название эвента соответственно.

Команды:

- Добавление события: 

`docker exec -it fpm php /data/test.local/index.php addEvent 3000 'param1=1,param2=2' ::event:1:3
`

- Удаление всех имеющихся событий:

`docker exec -it fpm php /data/test.local/index.php deleteEvents`

- Ответ на запрос пользователя:

`docker exec -it fpm php /data/test.local/index.php getEvent 'param1=1'`