# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Подготовка приложения
```
docker build -t php-composer ./
docker run -v ./code:/var/www/html -ti php-composer composer install
```
Занести корректные занчениея параметров в файле ./code/app.ini.
Список параметров:
host     Адрес сервера elasticsearch в формате host:port. Параметр обязателен.
user     Имя пользователя для подключения elasticsearch
password Пароль для подключения elasticsearch
index    Название индекса к которому будут производится запросы
caCert   Путь до файла с сертификатом для подписывания запросов к elasticsearch 

## Запуск приложения
```
docker run -v ./code:/var/www/html -ti php-composer php ./app.php -c [OPTIONS]
```
Список возможных опций:
-h      Вывод справки
-c      Поисковая фраза
-l      Цена меньше чем
-e      Цена равна
-g      Цена больше чем
