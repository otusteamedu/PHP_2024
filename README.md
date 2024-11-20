# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Подготовка и запуск приложения
```
cd <project folder>
docker compose build
docker compose up -d
docker exec -ti app /bin/bash -c "cd /data/mysite.local && composer install && php artisan migrate --force && php artisan storage:link"
```

## Добавление новости
Добавление новости осуществляется POST запросом на URI **/api/news** в теле которого пердается json-объект с URL новости
Запрос:
```
curl --request POST \
  --url http://mysite.local/api/news \
  --header 'Content-Type: application/json' \
  --data '{
	"url": "https://lenta.ru/news/2024/08/23/cpanel/"
}'
```
Ответ:
```
{
	"id": 1
}
```

## Получение списка новостей
Получение списка новостей осуществляется GET запросом без параметров  на URI **/api/news** 
Запрос:
```
curl --request GET \
  --url http://mysite.local/api/news 
```
Ответ:
```
{
    "newsList": [
        {
            "id": 1,
            "title": "Из Windows исчезнет «Панель управления»: Софт: Наука и техника: Lenta.ru",
            "url": "https:\/\/lenta.ru\/news\/2024\/08\/23\/cpanel\/",
            "exportDate": "2024-08-24"
        },
        {
            "id": 2,
            "title": "REST API на Laravel в 100 строк кода &#x2F; Хабр",
            "url": "https:\/\/habr.com\/ru\/articles\/441946\/",
            "exportDate": "2024-08-24"
        }
    ]
}
```

## Генерация отчета
Генерация осуществляется GET запросом на URI **/api/news/report** с параметром ids[] содержащим список id новостей для отчета
Запрос:
```
curl --request GET \
  --url 'http://mysite.local/api/news/report?ids%5B%5D=1&ids%5B%5D=2'
```
Ответ:
```
{
	"reportUrl": "http:\/\/mysite.local\/storage\/66c958e1daf51.html"
}
```