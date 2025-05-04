# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

docker-compose up --build -d
docker compose exec -it app bash
composer install
php artisan migrate

### Для того чтобы очереди начали обрабатываться, необходимо запустить процесс, используя следующую команду:
```
php artisan queue:process   
```

[Ссылка на документацию API](./code/storage/api-docs/api-docs.json)
![img_1.png](img_1.png)

### Тестирование API
Создание запроса POST
![img.png](img.png)

![img_2.png](img_2.png)

![img_3.png](img_3.png)


Создание запроса GET
![img_4.png](img_4.png)

Создание запроса PUT 
![img_5.png](img_5.png)