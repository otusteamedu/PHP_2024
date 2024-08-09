# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus


## Подготовка и запуск приложения
```
cd <project folder>
docker compose build .
docker run -v "./code:/data/mysite.local" -ti php_app /bin/bash -c "cd /data/mysite.local && composer install"
docker compose up
```

## Настройка приложения 
Настройка приложения осуществляется посредством файла app.ini.

### Управление хранилищем
Посредством параметра ***adapter*** в секции ***Registry***.
Возможные значениея: **redis** и **memcached**.
Параметры подключения к хранилющу задаются в секции ***Redis*** или ***Memcached*** соответственно.
Доступные параметры: **host** и **port**.

## API
### Очистка хранилища
Очистка хранилища осуществляется при помощи GET запроса на URI /flush
```
curl --request GET \
  --url http://mysite.local/flush 
```

### Добавление события
Для добавления события необходимо выполнить POST запрос на URI /add.
В теле запроса передается json-объект с описанием события.
```
curl --request POST \
  --url http://mysite.local/add \
  --header 'Content-Type: application/json' \
  --data '{
	"priority": 100,
	"conditions": {
		"param1": 1,
		"param2":  2
	},
	"event": "eventName2"
}'
``` 

### Поиск события по параметрам
Для поиска события удовлетворяющего заданым параметрам и имееющего максимальный приоритет необходимо выполнить GET запрос на URI /search. В теле запроса передается объект с прараметрами поиска.
```
curl --request GET \
  --url http://mysite.local/search \
  --header 'Content-Type: application/json' \
  --data '{
	"params": {
		"param1": 1,
		"param2": 2
	}
}'
```