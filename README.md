# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Подготовка и запуск приложения
```
cd <project folder>
docker compose build .
docker run -v "./code:/data/mysite.local" -ti php_app /bin/bash -c "cd /data/mysite.local && composer install"
docker compose up
применить скрипт ddl.sql к целевой БД
```

## Настройка приложения 
Настройка приложения осуществляется посредством файла app.ini.

## Добавление данных
Добавление новой записи в БД осуществляется отправкой POST запроса на URI /.
В теле запроса передается json-объект с описанием фильма (**свойства id в объекте быть не должно**)
```
curl --request POST \
  --url http://mysite.local/ \
  --header 'Content-Type: application/json' \
  --data '{
	"title": "film",
	"description": "d",
	"publish_year": 555,
	"deleted_at":null
}'
```

## Обавление данных
Обнавление записи в БД осуществляется отправкой POST запроса на URI **/**.
В теле запроса передается json-объект с описанием фильма (**свойства id обязательно**)
```
curl --request POST \
  --url http://mysite.local/ \
  --header 'Content-Type: application/json' \
  --data '{
    "id": 1,
	"title": "film",
	"description": "d",
	"publish_year": 555,
	"deleted_at":null
}'
```

## Получиние записи по id
Для получение записи по id необходимо выполнить GET запрос вида **/?id=value**
```
curl --request GET \
  --url 'http://mysite.local/?id=1'
```

## Получиние всех не удаленных записей
Для всех не удаленных записей необходимо отправит GET запрос без параметров на URI **/**.
```
curl --request GET \
  --url 'http://mysite.local/'
```
