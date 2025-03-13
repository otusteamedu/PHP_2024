# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

-hw30
- Использую фремворк lumen (директория hw30)
- Подключаем базу данных - файл .env 
    DB_DATABASE=...
    DB_USERNAME=...
    DB_PASSWORD=...
- Активизируем очереди (https://lumen.laravel.com/docs/11.x/queues)
    php artisan queue:table
    php artisan queue:failed-table
    Добавляем строку (hw30/app/bootstrap/app.php) - $app->configure('queue');
- Делаем таблицу данных orders
    php artisan make:migration orders
    редактируем файл - app/database/migration/2025..orders.php
- Создаем таблицы в базе
    php artisan migrate
- Делаем модели
    Для простоты работы включаем Eloquent - Добавляем строку (hw30/app/bootstrap/app.php) - $app->withEloquent();
    Создаем модель Order - hw30/app/Models/Order.php 
- Делаем контроллер OrderController и простейший роутинг 
    OrderController - (hw30/app/Http/Controllers)
    /add и /show/{id} (hw30/routes/web.php) 
- Запускаем и проверяем
    php -S localhost:8000 -t public
    Заходим localhost:8000/add (добавляем в базу)
    Смотрим localhost:8000/show/1 - status done
  Сразу все отрабатывается а одном запросе, зачем очереди? Посыпаем голову пеплом/бьемся головой об стену  

- Меняем настройку обработки очередей
    hw30/.env QUEUE_CONNECTION=database
  Добавлаем в базу заказы localhost:8000/add
- Запускаем обработку очередей в терминале
    php artisan queue:work
    Смотрим что все статусы done

- Делаем файл Orders.yml для Swagger     