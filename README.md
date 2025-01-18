# Инструкция по установке и запуску приложения

## Установка и запуск

1. Убедитесь, что у вас установлен Docker и Docker Compose.
2. Клонируйте репозиторий на ваш компьютер:

    ```bash
    git clone -b KRudenko/hw4 git@github.com:otusteamedu/PHP_2024.git
    ```

3. Перейдите в каталог с репозиторием:

    ```bash
    cd PHP_2024
    ```

4. Соберите и запустите контейнеры Docker с помощью Docker Compose:

    ```bash
    docker-compose up -d
    ```

# Проверка работы кластера

Каждый раз делая запрос `localhost`, будет выводиться имя хоста:

   ```shell
   Hello from hostname php-fpm2!
   ```

# Проверка работы скобок

## Успешный запрос

   ```shell
   curl -X POST -w "\nHTTP Code: %{http_code}" localhost/string -d "string=(()()()())((((()()()))(()()()(((()))))))"
   ```

## Неуспешный запрос

   ```shell
   curl -X POST -w "\nHTTP Code: %{http_code}" localhost/string -d "string=(()()()()))((((()()()))(()()()(((()))))))"
   ```

## Пустой запрос

   ```shell
   curl -X POST -w "\nHTTP Code: %{http_code}" localhost/string -d "string"
   ```

## Неверный метод

   ```shell
   curl -X GET -w "\nHTTP Code: %{http_code}" localhost/string -d "string"
   ```

# Проверка работы сессий

## Из браузера или postman

Запросите адрес `localhost/session` несколько раз подряд и вы увидите,
что в каждом запросе сессия остается неизменной, а счетчик увеличивается. 

## Из консоли

Выполните запрос, что бы получить id сессии:
   
   ```shell
   curl localhost/session
   ```

Затем подставьте полученный id сессии в следующий запрос вместо `{SESSION_ID}`.
Каждый раз выполняя запрос, вы увидите как увеличивается счетчик:

   ```shell
   curl localhost/session -H 'Cookie: PHPSESSID={SESSION_ID}'
   ```

## Контейнер докера

   ```shell
   docker exec -it otus-redis redis-cli
   keys *
   ```
