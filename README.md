# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus


Команды:

## Очистка индекса (если существует), создание нового индекса с mapping, загрузка json файла

```sh
docker exec -it app php app.php init
```

## Поиск, пример запроса

```sh
docker exec -it app php app.php search --query='рыцОри' --priceGTE=2000 --priceLTE=3000 --stockMinQuantity=2 --stockName='Ленина'
```

## Допустимые параметры
- category - категория
- query - поиск по title
- priceGTE - цена >=
- priceGT - цена >
- priceLTE - цена <=
- priceLT - цена <
- stockMinQuantity - минимальное количество в магазине
- stockName - поиск по названию магазина