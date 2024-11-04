# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## 1) Добавление новости.##

Запрос (для Linux):

```
curl --location 'http://localhost/api/v1/news/add' \
--header 'Content-Type: application/json' \
--data '{
    "url": "https://auto.mail.ru/"
}'
```

Ответ:
```
{
    "id": 22
}
```

## 2) Получение списка новостей. ##

Запрос (для Linux):

```
curl --location 'http://localhost/api/v1/news/list'
```

Ответ:
```
{
    "newsList": [
        {
            "id": 24,
            "date": "2024-11-03 23:44:34",
            "url": "https://auto.mail.ru/",
            "title": "Авто Mail: новости авторынка, тест-драйвы, краш-тесты, обзоры, электромобили, советы экспертов по покупке и продаже"
        },
        {
            "id": 16,
            "date": "2024-11-01 12:37:10",
            "url": "https://auto.mail.ru/article/97833-u-dilerov-poyavilas-samaya-dorogaya-lada-vesta-s-novyimi-optsiyami/?frommail=1",
            "title": "У дилеров появилась самая дорогая Lada Vesta с новыми опциями"
        },
                {
            "id": 1,
            "date": "2024-11-01 05:30:27",
            "url": "https://ya.ru",
            "title": "Яндекс — быстрый поиск в интернете"
        }
    ]
}
```

## 3) Формирование сводного отчёта. ##

Запрос (для Linux):

```
curl --location --globoff 'http://localhost/api/v1/news/report?ids[]=1&ids[]=16&ids[]=24' \
--header 'Content-Type: application/json'
```

Ответ:
```

```
