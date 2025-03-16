# HW20 Сыроваткин А.С

Скопировать template.env в .env
Скопировать code\.env.example в code\.env 
Запустить стенд docker-compose up
В контейнере app выполнить команду php artisan migrate

Алгоритм работы:
1. Сделать post запрос `curl --location 'http://mysite.local//some_request' --header 'Content-Type: application/json' --header 'Accept: application/json' --data '{"data": "qqqqq"}'` - запросу будет присвоен id, а сообщение отправлено в очередь. Id будет в ответе. 
2. Сделать get запрос с указанием id для проверки статуса ('not processed' - не обработан) `curl --location 'http://mysite.local//check_status?id=1' --header 'Accept: application/json'`'
3. Зайти на страницу 'http://mysite.local/' - будет обработано сообщение из очереди
3. Сделать get запрос с указанием id для проверки статуса ('completed' - обработан) `curl --location 'http://mysite.local//check_status?id=1' --header 'Accept: application/json'`'

Можно используя swagger.json делать запросы из PostMan