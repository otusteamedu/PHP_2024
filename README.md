# PHP_2024
Описание/Пошаговая инструкция выполнения домашнего задания:

Необходимо реализовать Rest API с использованием очередей.

Ваши клиенты будут отправлять запросы на обработку, а вы будете складывать их в очередь и возвращать номер запроса.

В фоновом режиме вы будете обрабатывать запросы, а ваши клиенты периодически, используя номер запроса, будут проверять статус его обработки.


Разрешается

- Использование Composer-зависимостей

- Использование микрофреймворков (Lumen, Silex и т.п.)


Критерии оценки:
5 баллов за реализацию API
3 балла за применение очередей
2 балла за документацию (например, в Swagger)

## Развертывание
### Сборка
Установка переменных .env.
```shell script
cp ./.env.dev .env &&

```
Сборка контейнеров
```shell script
docker-compose build
```

### Запуск контейнеров
```shell script
docker-compose up -d &&
docker-compose exec app bash -c "export COMPOSER_HOME=/data/mysite.local && composer install" 
```
### Наполнение базы
```shell script
docker-compose exec app bash -c "php bin/console doctrine:migrations:migrate" 
```
### Запуск обработчика очереди 
```shell script
docker-compose exec app bash -c "php bin/console rabbitmq:consumer statement -m 100 " 
```
## Документация OpenAPI
http://mysite.local/api/doc

## Запросы
### Отправка запроса
Отправляем запрос для создания аккаунта(можно использовать запрос create_account из postman collection)
POST запрос http://mysite.local/api/v1/request
#### Request Body
```json
{
  "requesterName": "name",
  "requesterEmail":"my_email@mail.ru"
}
```
```shell script
curl --location 'http://mysite.local/api/v1/request' \
--form 'requesterName="name"' \
--form 'requesterEmail="my_email@mail.ru"'
```
В ответе придет номер запроса который можно использовать для проверки статуса запроса
### Проверка статуса запроса
GET запрос http://mysite.local/api/v1/request?requestId=5

```shell script
curl --location 'http://mysite.local/api/v1/request?requestId=19' 
```