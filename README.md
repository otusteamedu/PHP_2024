# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

#### запуск приложения
``docker-compose up``
#### перейдите на mysite.local и отправьте форму с данными пользователя
``docker compose exec -it app bash``
#### запустите в консоли в контейнере php команду в корне приожения
``php cron.php``
#### отправка уведомления приходит в телеграмм бот @EskonyaevaBot
``(В классе App\Infrastructure\Services\ReceiverRabbitMQ можно поменять параметры token и и ваш telegram_admin_id)``