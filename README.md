# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Подготовка приложения
```
docker build -t php-socket ./
docker run -v ./code:/var/www/html -ti php-socket composer dump-autoload
```
## Запуск сервера
```
docker run -v ./code:/var/www/html -v ./socket:/run/chat -ti php-socket php ./app.php server
```
## Запуск клиента
```
docker run -v ./code:/var/www/html -v ./socket:/run/chat -ti php-socket php ./app.php client
```